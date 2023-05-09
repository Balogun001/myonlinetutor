<?php

use GuzzleHttp\Psr7\Query;

/**
 * This Controller is used for user quiz solving
 *
 * @package YoCoach
 * @author Fatbit Team
 */
class PublicQuizController extends MyAppController  //DashboardController
{
    /**
     * Initialize
     *
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
    }

    /**
     * Render Instructions Form
     *
     * @param int $id
     */
    public function index(int $id)
    {
        $db = FatApp::getDb();
            $check = $db->query("SELECT quizat_id FROM tbl_quiz_attempts WHERE session_id = '".session_id()."' AND quiz_id = ".$id." ORDER BY quizat_id DESC LIMIT 1");
            $check_quiz = $db->fetch($check);
            if(isset($check_quiz['quizat_id']) && $check_quiz['quizat_id'] != ''){
                FatApp::redirectUser(MyUtility::generateUrl('UserQuiz', 'index', [$check_quiz['quizat_id']]));
            }
        $quiz_data = Quiz::getById($id);
        if (empty($quiz_data)) {
            FatUtility::exitWithErrorCode(404);
        }
        $quiz = new QuizLinked(0, $quiz_data['quiz_user_id'], 0, 0);
        
        if (!$quiz->setuppublic(401, 1, [$quiz_data['quiz_id']],$quiz_data['quiz_user_id'],0)) {
            FatUtility::exitWithErrorCode(404);
        }

        //search
        
        $query = $db->query("SELECT quilin_id FROM tbl_quiz_linked WHERE quilin_quiz_id = ".$quiz_data['quiz_id']." AND quilin_record_id = 401 AND quilin_user_id = ".$quiz_data['quiz_user_id']." AND quilin_record_type=1 AND quilin_deleted IS NULL ORDER BY quilin_id DESC LIMIT 1");
        $data_q = $db->fetch($query);
        $query2 = $db->query("SELECT quizat_id FROM tbl_quiz_attempts WHERE quizat_quilin_id = ".$data_q['quilin_id']." ORDER BY quizat_id DESC LIMIT 1");
        $data2 = $db->fetch($query2);
        $query3 = $db->query("UPDATE  tbl_quiz_attempts SET session_id = '".session_id()."' , quiz_id = ".$quiz_data['quiz_id']." WHERE quizat_quilin_id = ".$data_q['quilin_id']);

        //quizz attempt
        FatApp::redirectUser(MyUtility::generateUrl('UserQuiz', 'index', [$data2['quizat_id']]));
    }

    
}
