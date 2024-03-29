<?php

require_once dirname(__FILE__) . '/../lib/class_vCard.php';
require_once dirname(__FILE__) . '/../lib/debug.php';

/**
 * Test class for class_vCard.
 * Generated by PHPUnit on 2010-11-15 at 07:14:46.
 * @author chunshengster@gmail.com
 *
 * all the test case that named testSet_xxxxxxx will be tested in testpaser_vcard().
 */
class class_vCardTest extends PHPUnit_Framework_TestCase {

    /**
     * @var class_vCard
     */
    protected $object;
//    protected $vcard;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new class_vCard();
        $vcard_text = file_get_contents('./a.vcf');
//        print_r($vcard_text);
        
        $this->object->parse_vCard($vcard_text);
//        print_r($this->object);
        print $this->object->get_vCard_Data();
//        var_export($this->object);
//        print_r($this->object);
        //print_r($this->vcard);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

//    public function test__destruct() {
//        // Remove the following lines when you implement this test.
//        $this->assertTrue($this->object instanceof class_vCard);
//    }

    /**
     * Implement testGet_vCard_Explanatory_Properties().
     */
    public function testGet_vCard_Explanatory_Properties() {
        // Remove the following lines when you implement this test.

        
//        print_r($this->object->get_vCard_Explanatory_Properties());
//        $vcard_tmp = array(
//            'UID' => 'bc441260-e692-11df-97aa-000c294ea793',
//            'REV' => '20101013111111',
//            'VERSION' => '3.0',
//            'LANGUAGE' => '',
//            'CATEGORIES' => '',
//            'PRODID' => '',
//            'SORT-STRING' => ''
//        );
//        $this->assertEquals($vcard_tmp, $this->object->get_vCard_Explanatory_Properties());
    }

    /**
     *  Implement testSet_vCard_Explanatory_Properties().
     */
//    public function testSet_vCard_Explanatory_Properties() {
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
//        $vcard_tmp = array(
//            'FN' => '王春生',
//            'N' => '王;春生;;;',
//            'NICKNAME' => '平凡的香草',
//            'PHOTO' => '',
//            'PhotoType' => '',
//            'BDAY' => '1981-04-18',
//            'URL' => 'http\://www.muduo.net',
//            'SOUND' => '',
//            'NOTE' => ''
//        );
//        $this->assertEquals($this->object->get_vCard_Identification_Properties(), $vcard_tmp);
//    }

    /**
     * @todo Implement testSet_vCard_Identification_Properties().
     */
//    public function testSet_vCard_Identification_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Delivery_Addressing_Properties_ADR().
     */
//    public function testGet_vCard_Delivery_Addressing_Properties_ADR() {
//        // Remove the following lines when you implement this test.
//        $vcard_tmp = array(
//            Array
//                (
//                'ADR' => ';;西城区西单北大街甲133号中国联通951房间;;;100032;',
//                'AdrType' => 'WORK,dom,home,postal,parcel',
//            ),
//            Array
//                (
//                'ADR' => ';;北京市西城区2222222222;;;123456;',
//                'AdrType' => 'dom,postal'
//            )
//        );
//        $key = array(
//            'idvCard_Delivery_Addressing_Properties_ADR' => 3
//        );
//        echo var_export($key,true);
//        echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_ADR($key), true);
//        $this->assertEquals($this->object->get_vCard_Delivery_Addressing_Properties_ADR(), $vcard_tmp);
//    }

    /**
     * @todo Implement testSet_vCard_Delivery_Addressing_Properties_ADR().
     */
//    public function testSet_vCard_Delivery_Addressing_Properties_ADR() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Delivery_Addressing_Properties_LABEL().
     */
//    public function testGet_vCard_Delivery_Addressing_Properties_LABEL() {
//        // Remove the following lines when you implement this test.
//        $vcard_tmp = array(
//            array(
//                'LABEL' => ( 'Mr.John Q. Public\, Esq.\n        Mail Drop\: TNE QB\n123 Main Street\nAny Town\, CA  91921-1234        \nU.S.A.'),
//                'LabelType' => 'dom,home,postal,parcel'
//            ),
//            array(
//                'LABEL' => ( '测试label'),
//                'LabelType' => 'parcel'
//            )
//        );
//        echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_LABEL(), true);
//        $this->assertEquals($this->object->get_vCard_Delivery_Addressing_Properties_LABEL(), $vcard_tmp);
//    }

    /**
     * @todo Implement testSet_vCard_Delivery_Addressing_Properties_LABEL().
     */
//    public function testSet_vCard_Delivery_Addressing_Properties_LABEL() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     *  Implement testGet_vCard_Geographical_Properties().
     *  there is a bug in FILE_IMC_BUILD_VCARD , in function getGeo();
     */
//    public function testGet_vCard_Geographical_Properties() {
//        // Remove the following lines when you implement this test.
//        $vcard_tmp = array(
//            'TZ' => '-05\:00\; EST\; Raleigh/North America',
//            'GEO' => '37.386013;-122.082932'
//        );
//        echo var_export($this->object->get_vCard_Geographical_Properties(), true);
//        $this->assertEquals($vcard_tmp, $this->object->get_vCard_Geographical_Properties());
//    }

    /**
     * @todo Implement testSet_vCard_Geographical_Properties().
     */
//    public function testSet_vCard_Geographical_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * Implement testGet_vCard_Organizational_Properties().
     */
//    public function testGet_vCard_Organizational_Properties() {
//        $vcard_tmp = array(
//            'TITLE' => '资深架构师',
//            'ROLE' => '',
//            'LOGO' => '',
//            'LogoType' => '',
//            'AGENT' => '',
//            'ORG' => '联通新时讯通信有限公司 unIcom中国联通'
//        );
//        print_r($this->object->get_vCard_Organizational_Properties());
//        echo var_export($this->object->get_vCard_Organizational_Properties(), true);
//        $this->assertEquals($this->object->get_vCard_Organizational_Properties(), $vcard_tmp);
//    }

    /**
     * @todo Implement testSet_vCard_Organizational_Properties().
     */
//    public function testSet_vCard_Organizational_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * Implement testGet_vCard_Telecommunications_Addressing_Properties_Email().
     */
//    public function testGet_vCard_Telecommunications_Addressing_Properties_Email() {
//        echo var_export($this->object->get_vCard_Telecommunications_Addressing_Properties_Email(), true);
//        $this->markTestSkipped('This test has been implemented!\n');
//    }

    /**
     * @todo Implement testSet_vCard_Telecommunications_Addressing_Properties_Email().
     */
//    public function testSet_vCard_Telecommunications_Addressing_Properties_Email() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testGet_vCard_Telecommunications_Addressing_Properties_Tel().
     */
//    public function testGet_vCard_Telecommunications_Addressing_Properties_Tel() {
//        echo var_export($this->object->get_vCard_Telecommunications_Addressing_Properties_Tel(), true);
//        $this->markTestSkipped('This test has been implemented!\n');
    /*
      $this->markTestIncomplete(
      'This test has not been implemented yet.'
      );
     */
//    }

    /**
     * @todo Implement testSet_vCard_Telecommunications_Addressing_Properties_Tel().
     */
//    public function testSet_vCard_Telecommunications_Addressing_Properties_Tel() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testParse_vCard().
     */
//    public function testParse_vCard() {
//        $this->markTestSkipped('This test has been implemented !\n');
//    }

    /**
     * @todo Implement testGet_vCard_From_Storage().
     */
//    public function testGet_vCard_From_Storage() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     *  Implement testPrint_parse_data().
     */
//    public function testPrint_parse_data() {
//        $this->object->print_parse_data();
//        $this->markTestSkipped();
//    }

    /**
     * @todo Implement testGet_vCard_property_from_storage().
     */
//    public function testGet_vCard_property_from_storage() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_vCard_Property_Into_Storage().
     */
//    public function testStore_vCard_Property_Into_Storage() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * Implement testStore_vCard_Explanatory_Properties().
     */
//    public function testStore_vCard_Explanatory_Properties() {
//
//        echo var_export($this->object->get_vCard_Explanatory_Properties(),true);
//        $re = $this->object->store_vCard_Explanatory_Properties();
//
//        echo var_export($this->object->get_vCard_Explanatory_Properties(),ture);
//    }

    /**
     * @todo Implement testStore_vCard_Identification_Properties().
     */
//    public function testStore_vCard_Identification_Properties() {
//        // Remove the following lines when you implement this test.
//        echo var_export($this->object->get_vCard_Identification_Properties(),true);
//        $re = $this->object->store_vCard_Identification_Properties();
//        echo var_export($re,true);
//        echo var_export($this->object->get_vCard_Identification_Properties(),ture);
//
//    }

    /**
     * @todo Implement testStore_vCard_Delivery_Addressing_Properties_ADR().
     */
//    public function testStore_vCard_Delivery_Addressing_Properties_ADR() {
//        // Remove the following lines when you implement this test.
//        echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_ADR(),true);
//        $re = $this->object->store_vCard_Delivery_Addressing_Properties_ADR();
//        echo var_export($re,true);
//        echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_ADR(),true);
//
//    }

    /**
     * @todo Implement testStore_vCard_Delivery_Addressing_Properties_LABEL().
     */
//    public function testStore_vCard_Delivery_Addressing_Properties_LABEL() {
//        // Remove the following lines when you implement this test.
//        echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_LABEL(),true);
//        $re = $this->object->store_vCard_Delivery_Addressing_Properties_LABEL();
//        echo var_export($re,true);
//        echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_LABEL(),true);
//    }

    /**
     * @todo Implement testStore_vCard_Geographical_Properties().
     */
//    public function testStore_vCard_Geographical_Properties() {
//        // Remove the following lines when you implement this test.
//        echo var_export($this->object->get_vCard_Geographical_Properties(),true);
//        $re = $this->object->store_vCard_Geographical_Properties();
//        echo var_export($re,true);
//        echo var_export($this->object->get_vCard_Geographical_Properties(),true);
//    }

    /**
     * @todo Implement testStore_vCard_Organizational_Properties().
     */
    /**
      public function testStore_vCard_Organizational_Properties() {
      // Remove the following lines when you implement this test.
      echo var_export($this->object->get_vCard_Organizational_Properties(),true);
      $re = $this->object->store_vCard_Organizational_Properties();
      echo var_export($this->object->get_vCard_Organizational_Properties(),true);
      }
     *
     */
    /**
     * @todo Implement testStore_vCard_Telecommunications_Addressing_Properties_Email().
     */
    /**
      public function testStore_vCard_Telecommunications_Addressing_Properties_Email() {

      echo var_export($this->object->get_vCard_Telecommunications_Addressing_Properties_Email(),true);
      $re = $this->object->store_vCard_Telecommunications_Addressing_Properties_Email();
      echo var_export($re,true);
      echo var_export($this->object->get_vCard_Telecommunications_Addressing_Properties_Email(),true);
      }
     *
     */
    /**
     * @todo Implement testStore_vCard_Telecommunications_Addressing_Properties_Tel().
     */
    /**
      public function testStore_vCard_Telecommunications_Addressing_Properties_Tel() {
      echo var_export($this->object->get_vCard_Telecommunications_Addressing_Properties_Tel(),true);
      $re = $this->object->store_vCard_Telecommunications_Addressing_Properties_Tel();
      echo var_export($re,true);
      echo var_export($this->object->get_vCard_Telecommunications_Addressing_Properties_Tel(),true);
      }
     *
     */

    /**
     * @todo implement testget_vCard_property_from_storage
     */
//    public function testget_vCard_property_from_storage() {
//        $key = array(
            //'UID'=>'bc441260-e692-11df-97aa-000c294ea794',
//            'idvCard_Explanatory_Properties' => 10,
            //'property'=>'vCard_Explanatory_Properties'
//            'property' =>'vCard_Identification_Properties',
//             'property' =>'vCard_Geographical_Properties',
//               'property' =>'vCard_Organizational_Properties'
//            'property' =>'vCard_Delivery_Addressing_Properties_LABEL'
//            'property' =>'vCard_Telecommunications_Addressing_Properties_Tel'
//            'property' => 'vCard_Telecommunications_Addressing_Properties_Email'
//        );
//        $re = $this->object->get_vCard_property_from_storage($key);
//        echo var_export($re,true);
        //echo var_export($this->object->get_vCard_Explanatory_Properties(),true);
//        echo var_export($this->object->get_vCard_Identification_Properties());
//        echo var_export($this->object->get_vCard_Geographical_Properties(),true);
//        echo var_export($this->object->get_vCard_Organizational_Properties(),true);
//        echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_ADR(),true);
//            echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_LABEL(),true);
//        echo var_export($this->object->get_vCard_Telecommunications_Addressing_Properties_Tel(),true);
//        echo var_export($this->object->get_vCard_Telecommunications_Addressing_Properties_Email(),true);
//    }

//    public function testget_Full_vCard_From_Storage() {
//        $re = $this->object->get_Full_vCard_From_Storage('bc441260-e692-11df-97aa-000c294ea794');
//        echo var_export($re,true);
//        if ($re) {
//            echo "<========================================>\n";
//            echo var_export($this->object->get_vCard_Delivery_Addressing_Properties_ADR());
//        }else{
//            echo "return Null!";
//        }
//    }
//
//    public function testget_vCard_Text() {
//        $re = $this->object->get_vCard_Text(true, 'bc441260-e692-11df-97aa-000c294ea794');
//        echo var_export($this->object,true);
//        echo var_export($re,true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
//
//    }


}

?>
