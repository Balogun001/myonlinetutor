var recordingPlayer;
var recordedPlayer;
var recordedStream;
var button;
(function () {
    var params = {},
        r = /([^&=]+)=?([^&]*)/g;

    function d(s) {
        return decodeURIComponent(s.replace(/\+/g, ' '));
    }

    var match, search = window.location.search;
    while (match = r.exec(search.substring(1))) {
        params[d(match[1])] = d(match[2]);

        if (d(match[2]) === 'true' || d(match[2]) === 'false') {
            params[d(match[1])] = d(match[2]) === 'true' ? true : false;
        }
    }

    window.params = params;
})();
function getPlayer() {
    recordingPlayer = document.querySelector('.audioRecorderJs audio');
    recordingPlayer.controlsList = "noplaybackrate nodownload nofullscreen";
    recordedPlayer = document.querySelector('.audioRecordingJs');
    recordedStream = '';
}
function captureAudio(config) {

    captureUserMedia({ audio: true }, function (audioStream) {
        $(button).find('.btnStartJs, .labelStartJs').hide();
        $(button).find('.btnStopJs, .labelStopJs').show();
        recordingPlayer.srcObject = audioStream;
        recordingPlayer.muted = true;

        config.onMediaCaptured(audioStream);

        audioStream.onended = function () {
            config.onMediaStopped();
        };
    }, function (error) {
        config.onMediaCapturingFailed(error);
    });
}


function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
    navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
}

$(document).ready(function () {
    $('body').on('click', '.btnRecordJs', function () {
        recordingPlayer.addEventListener('pause', () => {
            recordingPlayer.play();
        });
        button = this;
        if ($(button).data('status') === langLbl.stopRecording) {
            $(button).find('.btnStartJs, .labelStartJs').show();
            $(button).find('.btnStopJs, .labelStopJs').hide();
            button.disableStateWaiting = true;
            setTimeout(function () {
                button.disabled = false;
                button.disableStateWaiting = false;
            }, 2 * 1000);

            $(button).data('status', langLbl.startRecording);

            function stopStream() {
                if (button.stream && button.stream.stop) {
                    button.stream.stop();
                    button.stream = null;
                }
            }
            if (button.recordRTC) {
                if (button.recordRTC.length) {
                    button.recordRTC[0].stopRecording(function (url) {
                        if (!button.recordRTC[1]) {
                            button.recordingEndedCallback(url);
                            stopStream();
                            recordedStream = button.recordRTC[0];
                            return;
                        }

                        button.recordRTC[1].stopRecording(function (url) {
                            button.recordingEndedCallback(url);
                            stopStream();
                        });
                    });
                } else {
                    button.recordRTC.stopRecording(function (url) {
                        button.recordingEndedCallback(url);
                        stopStream();
                        recordedStream = button.recordRTC;
                    });
                }
            }

            return;
        }

        var commonConfig = {
            onMediaCaptured: function (stream) {
                button.stream = stream;
                if (button.mediaCapturedCallback) {
                    button.mediaCapturedCallback();
                }

                $(button).data('status', langLbl.stopRecording);
                button.disabled = false;
                $(recordingPlayer).parent().css('display', 'block');
                $(recordedPlayer).find('audio').remove();
                $(recordedPlayer).css('display', 'none');
            },
            onMediaStopped: function () {
                $(button).data('status', langLbl.startRecording);

                if (!button.disableStateWaiting) {
                    button.disabled = false;
                }
            },
            onMediaCapturingFailed: function (error) {
                if (error.name == 'NotFoundError') {
                    $(button).find('.btnStartJs, .labelStartJs').show();
                    $(button).find('.btnStopJs, .labelStopJs').hide();
                    fcom.error(langLbl.noDeviceDetected);
                } else if (error.name === 'PermissionDeniedError' && !!navigator.mozGetUserMedia) {
                    $(button).find('.btnStartJs, .labelStartJs').show();
                    $(button).find('.btnStopJs, .labelStopJs').hide();
                    fcom.error(langLbl.noDeviceDetected);
                }

                commonConfig.onMediaStopped();
            }
        };

        captureAudio(commonConfig);

        button.mediaCapturedCallback = function () {
            button.recordRTC = RecordRTC(button.stream, {
                type: 'audio',
                bufferSize: typeof params.bufferSize == 'undefined' ? 0 : parseInt(params.bufferSize),
                sampleRate: typeof params.sampleRate == 'undefined' ? 44100 : parseInt(params.sampleRate),
                leftChannel: params.leftChannel || false,
                disableLogs: params.disableLogs || false,
                recorderType: DetectRTC.browser.name === 'Edge' ? StereoAudioRecorder : null
            });

            button.recordingEndedCallback = function (url) {
                var audio = new Audio();
                audio.src = url;
                audio.controls = true;
                recordingPlayer.parentNode.style.display = 'none';
                $(recordedPlayer).append(audio);
                $(recordedPlayer).find('audio').attr('controlsList', "noplaybackrate nodownload nofullscreen");
                $(recordedPlayer).css('display', 'block');
                $('input[name="audio_filename"]').val(1);
                $('.btnRemoveJs').show();

                audio.onended = function () {
                    audio.pause();
                    audio.src = URL.createObjectURL(button.recordRTC.blob);
                };
            };

            button.recordRTC.startRecording();
        };

    });
});






function appendRecordedFile(formData) {
    if (!recordedStream) {
        return formData;
    }
    var blob = recordedStream instanceof Blob ? recordedStream : recordedStream.blob;
    var fileType = blob.type.split('/')[0] || 'audio';
    var fileName = (Math.random() * 1000).toString().replace('.', '');
    if (fileType === 'audio') {
        fileName += '.' + (!!navigator.mozGetUserMedia ? 'ogg' : 'wav');
    } else {
        fileName += '.webm';
    }

    formData.append(fileType + '_filename', fileName);
    var file = new File([blob], fileName);
    formData.append(fileType + '_file', file);
    return formData;
}

function removeRecordedFile() {
    recordedStream = '';
	if (!recordingPlayer) {
        return;
    }
    $(recordingPlayer).attr('src', '').parent().show();
    recordingPlayer.load();
    recordingPlayer.pause();
    recordingPlayer.controlsList = "noplaybackrate nodownload nofullscreen";
    $('.recordrtc').removeClass('hasFile');
    var recordedAudio = $(recordedPlayer).find('audio');
    $(recordedAudio).parent().hide();
    $(recordedAudio).remove();
    $('input[name="audio_filename"]').val('');
    $('.btnRemoveJs').hide();
}