<?php

require_once dirname(__FILE__) . '/../../trunk/class_vcard_storage.php';

/**
 * Test class for class_vcard_storage.
 * Generated by PHPUnit on 2010-12-16 at 07:38:52.
 */
class class_vcard_storageTest extends PHPUnit_Framework_TestCase {

    /**
     * @var class_vcard_storage
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new class_vcard_storage;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @todo Implement test__destruct().
     */
    public function test__destruct() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGet_vCard_Explanatory_Properties().
     */
//    public function testGet_vCard_Explanatory_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Identification_Properties().
     */
//    public function testGet_vCard_Identification_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Telecommunications_Addressing_Properties_Tel().
     */
//    public function testGet_vCard_Telecommunications_Addressing_Properties_Tel() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Telecommunications_Addressing_Properties_Email().
     */
//    public function testGet_vCard_Telecommunications_Addressing_Properties_Email() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Delivvery_Addressing_Properties_LABEL().
     */
//    public function testGet_vCard_Delivvery_Addressing_Properties_LABEL() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Delivvery_Addressing_Properties_ADR().
     */
//    public function testGet_vCard_Delivvery_Addressing_Properties_ADR() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Organizational_Properties().
     */
//    public function testGet_vCard_Organizational_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Geographical_Properties().
     */
//    public function testGet_vCard_Geographical_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vcard_id_by_uid().
     */
//    public function testGet_vcard_id_by_uid() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_data().
     */
    public function testStore_data() {
        // Remove the following lines when you implement this test.
        $vcard_data_array = array(
            'UID' => '11111260-e692-11df-97sd-000c294ea794',
            'REV' => '201012181214',
            'VERSION' => '2.5',
            'LANGAGE' => '',
            'CATEGORIES' => '',
            'PRODID' => '',
            'SORT-STRING' => ''
        );
        /**
          $re = $this->object->store_data('vCard_Explanatory_Properties', $vcard_data_array);
          echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($re, true)));
         * 
         */
        $vcard_data_array = array(
            'FN' => '王春生',
            'N' => '王;春生;;;',
            'NICKNAME' => '平凡的香草ssssssss',
            'PHOTO' => '',
            'PhotoType' => '',
            'BDAY' => '1981-05-18',
            'URL' => 'http\://www.muduo.net',
            'SOUND' => '',
            'NOTE' => ''
        );
        /*
          echo  implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($vcard_data_array, true)));
          $re = $this->object->store_data('vCard_Identification_Properties', array_merge($vcard_data_array,array('V_ID'=>6)));
          echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($re, true)));
         *
         */

        //$vCard_Geographical_Properties
        $vcard_data_array = array(
            'TZ' => '-05\:00\; CST\; Asia\/Shanghai',
            'GEO' => '37.386013;-122.082932'
        );
//        echo  implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($vcard_data_array, true)));
//        $re = $this->object->store_data('vCard_Geographical_Properties', array_merge($vcard_data_array,array('RESOURCE_ID'=>1)));
////        $re = $this->object->store_data('vCard_Geographical_Properties', array_merge($vcard_data_array,array('V_ID'=>7)));
//        echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($re, true)));
//
        $vcard_data_array = array(
            array(
                'ADR' => ';;西城区西单北大街甲133号中国联通951房间;;;100032;',
                'AdrType' => 'WORK,dom,home,postal,parcel',
            ),
            array(
                'ADR' => ';;北京市西城区2222222222;;;123456;',
                'AdrType' => 'dom,postal',
                'RESOURCE_ID' => 4
            )
        );
        /**
          echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($vcard_data_array, true)));
          $re = $this->object->store_data('vCard_Delivery_Addressing_Properties_ADR', array_merge($vcard_data_array, array('V_ID' =>6)));
          echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($re, true)));
         *
         */
        $vcard_data_array = array(
            array(
                'TEL' => '(010)66505674',
                'TelType' => 'WORK,FAX'
            ),
            array(
                'TEL' => '01066505725',
                'TelType' => 'WORK'
            ),
            array(
                'TEL' => '18601108092',
                'TelType' => 'CELL'
            ),
            array(
                'TEL' => '13810154397',
                'TelType' => 'CELL',
//                'RESOURCE_ID' => 3
            ),
        );
        /**
          echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($vcard_data_array, true)));
          $re = $this->object->store_data('vCard_Telecommunications_Addressing_Properties_Tel', array_merge($vcard_data_array, array('V_ID' =>7)));
          echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($re, true)));
         * 
         */
        $vcard_data_array = array(
            array(
                'EMAIL' => 'chunshengster@gmail.com',
                'EmailType' => 'INTERNET',
            ),
            array(
                'EMAIL' => 'chunge@wo.com.cn',
                'EmailType' => 'INTERNET,WORK',
            ),
            array(
                'EMAIL' => '18601108092@wo.com.cn',
                'EmailType' => 'INTERNET,HOME',
                'RESOURCE_ID'=>3
            )
        );
        
        /**
        echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($vcard_data_array, true)));
        $re = $this->object->store_data('vCard_Telecommunications_Addressing_Properties_Email', array_merge($vcard_data_array, array('V_ID' => 6)));
        echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($re, true)));
         * 
         */


        $vcard_data_array = array(
            array(
                'LABEL' => 'Mr.John Q. Public\\, Esq.\\n        Mail Drop\\: TNE QB\\n123 Main Street\\nAny Town\\, CA  91921-1234        \\nU.S.A.',
                'LabelType' => 'dom,home,postal,parcel',
            ),
            array(
                'LABEL' => '测试label测试测试测试测试测试测试测试测试测试测试测试测试',
                'LabelType' => 'parcel',
                'RESOURCE_ID'=>2
            )
        );
        /*
        echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($vcard_data_array, true)));
        $re = $this->object->store_data('vCard_Delivery_Addressing_Properties_LABEL', array_merge($vcard_data_array, array('V_ID' => 6)));
        echo implode(':', array(__FILE__, __METHOD__, __LINE__, var_export($re, true)));
         * 
         */
    }

    /**
     * @todo Implement testCheck_vcard_exist_via_uid().
     */
    public function testCheck_vcard_exist_via_uid() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}

?>
