<?php

require_once dirname(__FILE__) . '/../../trunk/class_vCard.php';

/**
 * Test class for class_vCard.
 * Generated by PHPUnit on 2010-11-15 at 07:14:46.
 */
class class_vCardTest extends PHPUnit_Framework_TestCase {

    /**
     * @var class_vCard
     */
    protected $object;
    protected $vcard;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new class_vCard;
        $this->vcard = file_get_contents('E:\xinshixun\Code\wo_vCard\phpunit\trunk\a.vcf');
//        print_r($this->vcard);
        $this->object->parse_vCard($this->vcard);
//        print_r($this->object);
        //print_r($this->vcard);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    public function test__destruct() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object instanceof class_vCard);
    }

    /**
     * Implement testGet_vCard_Explanatory_Properties().
     */
    public function testGet_vCard_Explanatory_Properties() {
        // Remove the following lines when you implement this test.
        $vcard_tmp = array(
            'UID' => '46464646646464654654646464646464646456464646',
            'REV' => '20101013111111',
            'VERSION' => '3.0',
            'LANGAGE' => '',
            'CATEGORIES' => '',
            'PRODID' => '',
            'SORT-STRING' => ''
        );
        /**
          $this->object->get_vCard_Explanatory_Properties();
       
        print_r($this->object->get_vCard_Explanatory_Properties());
         *
         */
        $this->assertEquals($vcard_tmp, $this->object->get_vCard_Explanatory_Properties());
    }

    /**
     * @todo Implement testSet_vCard_Explanatory_Properties().
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
    public function testGet_vCard_Identification_Properties() {
        // Remove the following lines when you implement this test.
        $vcard_tmp = array(
            'FN' => '于淇',
            'N' => '于;淇;;;',
            'NICKNAME' => '于淇,齐齐',
            'PHOTO' => '',
            'PhotoType' => '',
            'BDAY' => '',
            'URL' => '',
            'SOUND' => '',
            'NOTE' => ''
        );
        $this->assertEquals($this->object->get_vCard_Identification_Properties(), $vcard_tmp);
    }

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
    public function testGet_vCard_Delivery_Addressing_Properties_ADR() {
        // Remove the following lines when you implement this test.
        $vcard_tmp = array(
            Array
                (
                'ADR' => ';;西城区西单北大街甲133号中国联通951房间;;;100032;',
                'Type' => 'WORK,dom,home,postal,parcel',
            ),
            Array
                (
                'ADR' => ';;北京市西城区2222222222;;;123456;',
                'Type' => 'domaaaa,postalaaaa'
            )
        );
        $this->assertEquals($vcard_tmp, $this->object->get_vCard_Delivery_Addressing_Properties_ADR());
    }

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
    public function testGet_vCard_Delivery_Addressing_Properties_LABEL() {
        // Remove the following lines when you implement this test.
        $vcard_tmp = array(
            array(
                'LABEL' => ( 'Mr.John Q. Public\, Esq.\n        Mail Drop\: TNE QB\n123 Main Street\nAny Town\, CA  91921-1234        \nU.S.A.'),
                'LabelType' => 'dom,home,postal,parcel'
            )
        );
        $this->assertEquals($this->object->get_vCard_Delivery_Addressing_Properties_LABEL(), $vcard_tmp);
    }

//
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
    public function testGet_vCard_Geographical_Properties() {
        // Remove the following lines when you implement this test.
        $vcard_tmp = array(
            'TZ' => '-05\:00\; EST\; Raleigh/North America',
            'GEO'=>'37.386013;-122.082932'
        );
        print_r($this->object->get_vCard_Geographical_Properties());
        $this->assertEquals($vcard_tmp, $this->object->get_vCard_Geographical_Properties());
    }

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
    public function testGet_vCard_Organizational_Properties() {


        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

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
     * @todo Implement testGet_vCard_Telecommunications_Addressing_Properties_Email().
     */
    public function testGet_vCard_Telecommunications_Addressing_Properties_Email() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

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
    public function testGet_vCard_Telecommunications_Addressing_Properties_Tel() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

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
    public function testParse_vCard() {
        // Remove the following lines when you implement this test.
//        print $this->object->parse_vCard($this->vcard);
//        print_r($this->object);
    }

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
     * @todo Implement testPrint_parse_data().
     */
//    public function testPrint_parse_data() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
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
     * @todo Implement testStore_vCard_Explanatory_Properties().
     */
//    public function testStore_vCard_Explanatory_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_vCard_Identification_Properties().
     */
//    public function testStore_vCard_Identification_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_vCard_Delivery_Addressing_Properties_ADR().
     */
//    public function testStore_vCard_Delivery_Addressing_Properties_ADR() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_vCard_Delivery_Addressing_Properties_LABEL().
     */
//    public function testStore_vCard_Delivery_Addressing_Properties_LABEL() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_vCard_Geographical_Properties().
     */
//    public function testStore_vCard_Geographical_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_vCard_Organizational_Properties().
     */
//    public function testStore_vCard_Organizational_Properties() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_vCard_Telecommunications_Addressing_Properties_Email().
     */
//    public function testStore_vCard_Telecommunications_Addressing_Properties_Email() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }

    /**
     * @todo Implement testStore_vCard_Telecommunications_Addressing_Properties_Tel().
     */
//    public function testStore_vCard_Telecommunications_Addressing_Properties_Tel() {
//        // Remove the following lines when you implement this test.
//        $this->markTestIncomplete(
//                'This test has not been implemented yet.'
//        );
//    }
}

?>
