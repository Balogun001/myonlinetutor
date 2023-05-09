<?php

use MailchimpMarketing\ApiClient;
//new
/**
 * Home Controller
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
class HomeController extends MyAppController
{
	

    /**
     * Initialize Home
     * 
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
    }

    /**
     * Render Website Homepage
     */
    public function index()
    {
		/*$stripe->customers->create([
		  'description' => 'My First Test Customer (created for API docs at https://www.stripe.com/docs/api)',
		]);*/
        $slides = Slide::getSlides();
		//$rating=$this->getratingDetail();
		//echo "<pre>";print_r($rating);die;
		$this->sets([
            'slides' => $slides,
            'slideImages' => Slide::getSlideImages(array_keys($slides), $this->siteLangId),
            'whyUsBlock' => ExtraPage::getBlockContent(ExtraPage::BLOCK_WHY_US, $this->siteLangId),
            'browseTutorPage' => ExtraPage::getBlockContent(ExtraPage::BLOCK_BROWSE_TUTOR, $this->siteLangId),
            'startLearning' => ExtraPage::getBlockContent(ExtraPage::BLOCK_HOW_TO_START_LEARNING, $this->siteLangId),
            'bookingBefore' => FatApp::getConfig('CONF_CLASS_BOOKING_GAP'),
            'popularLanguages' => TeachLanguage::getPopularLangs($this->siteLangId),
            'testmonialList' => Testimonial::getTestimonials($this->siteLangId),
            'blogPostsList' => BlogPost::getBlogsForGrids($this->siteLangId),
            'topRatedTeachers' => $this->getTopRatedTeachers(),
			'ratings'=>$this->getratingDetail()
        ]);
        $class = new GroupClassSearch($this->siteLangId, $this->siteUserId, $this->siteUserType);
        $this->set('classes', $class->getUpcomingClasses());
        $this->_template->addJs(['js/app.timer.js']);
        if(isset($_GET['ref']) && $_GET['ref']){
            $_SESSION['ref'] = $_GET['ref'];
            $refferal = new Refferals();
            $refferal->opened($_SESSION['ref']);
        }

        $this->_template->render();
    }

    /**
     * Setup News Letter
     */
    public function setUpNewsLetter()
    {
        $post = FatApp::getPostedData();
        $apikey = FatApp::getConfig("CONF_MAILCHIMP_KEY");
        $listId = FatApp::getConfig("CONF_MAILCHIMP_LIST_ID");
        $prefix = FatApp::getConfig("CONF_MAILCHIMP_SERVER_PREFIX");
        if (empty($apikey) || empty($listId) || empty($prefix)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_NOT_CONFIGURED_PLEASE_CONTACT_SUPPORT'));
        }
        try {
            $mailchimp = new ApiClient();
            $mailchimp->setConfig(['apiKey' => $apikey, 'server' => $prefix]);
            $response = $mailchimp->ping->get();
            if (!isset($response->health_status)) {
                FatUtility::dieJsonError(Label::getLabel('LBL_CONFIGURED_ERROR_MESSAGE'));
            }
            $subscriber = $mailchimp->lists->addListMember($listId, ['email_address' => $post['email'], 'status' => 'subscribed'], true);
            if ($subscriber->status != 'subscribed') {
                FatUtility::dieJsonError(Label::getLabel('MSG_NEWSLETTER_SUBSCRIPTION_VALID_EMAIL'));
            }
        } catch (Exception $e) {
            FatUtility::dieJsonError($e->getMessage());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('MSG_SUCCESSFULLY_SUBSCRIBED'));
    }

    /**
     * Get Top Rated Teachers
     * 
     * @return array
     */
    private function getTopRatedTeachers(): array
    {

		$db = FatApp::getDb();
        $srch = new TeacherSearch($this->siteLangId, $this->siteUserId, User::LEARNER);
        $srch->addMultipleFields([
            'teacher.user_first_name', 'teacher.user_last_name',
            'teacher.user_id', 'user_username', 'testat.testat_ratings',
            'teacher.user_country_id',
            'testat.testat_reviewes',
        ]);
		
        $srch->applyPrimaryConditions();
        $srch->addCondition('testat_ratings', '>', 0);
        $srch->addOrder('testat_ratings', 'DESC');
        $srch->setPageSize(8);
        $srch->doNotCalculateRecords();
        $records = FatApp::getDb()->fetchAll($srch->getResultSet(), 'user_id');
		$countryIds = array_column($records, 'user_country_id');
        $countries = TeacherSearch::getCountryNames($this->siteLangId, $countryIds);
        foreach ($records as $key => $record) {
            $records[$key]['country_name'] = $countries[$record['user_country_id']] ?? '';
            $records[$key]['full_name'] = $record['user_first_name'] . ' ' . $record['user_last_name'];
			$records[$key]['min_price'] = $this->teachLangPrices($record['user_id']);
			$sql="SELECT tbl_teach_languages_lang.tlanglang_tlang_id, tbl_teach_languages_lang.tlang_name, tbl_user_teach_languages.utlang_user_id FROM tbl_teach_languages_lang INNER JOIN tbl_user_teach_languages where  tbl_teach_languages_lang.tlanglang_tlang_id=tbl_user_teach_languages.utlang_tlang_id AND tbl_user_teach_languages.utlang_user_id=".$key; 
			$rs = $db->query($sql); 
			$records[$key]['languages']=$db->fetchAll($rs);
        }
		//echo "<pre>";print_r($records);die; 
        return $records;
    }
	 private function teachLangPrices(int $teacherId): array{
        $userTeachLang = new UserTeachLanguage($teacherId);
        $srchLang = $userTeachLang->getSrchObject($this->siteLangId, true);
        $srchLang->doNotCalculateRecords();
        $srchLang->addMultipleFields([
            'IFNULL(tlang_name, tlang_identifier) as teachLangName', 'utlang_id', 'utlang_tlang_id',
            'ustelgpr_slot', 'ustelgpr_price', 'ustelgpr_min_slab', 'ustelgpr_max_slab', 'ustelgpr_price'
        ]);
        $srchLang->addCondition('ustelgpr_price', '>', 0);
        $srchLang->addCondition('ustelgpr_min_slab', '>', 0);
        return FatApp::getDb()->fetchAll($srchLang->getResultSet());
    }
	public function getratingDetail()
    {
		$db = FatApp::getDb();
		$sql="SELECT tbl_rating_reviews.ratrev_detail,tbl_users.user_first_name,tbl_users.user_last_name FROM tbl_rating_reviews INNER JOIN tbl_users where  tbl_rating_reviews.ratrev_user_id=tbl_users.user_id AND tbl_rating_reviews.ratrev_overall=5"; 
		$rs = $db->query($sql); 
		$records=$db->fetchAll($rs);
        //echo "<pre>";print_r($records);die;
		return $records;
		
    }

}
