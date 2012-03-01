<?php

/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/LICENSE-M1.txt
 *
 * @category   AW
 * @package    AW_Collpur
 * @copyright  Copyright (c) 2008-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/LICENSE-M1.txt
 */
class AW_Blog_Test_Helper_Substring extends EcomDev_PHPUnit_Test_Case {

    /**
     *  @test
     *  @dataProvider provider__getHtmlSubstr
     * 
     */
    public function getHtmlSubstr($data) {

        $strManager = new AW_Blog_Helper_Substring(array('input' => $data['string']));
        $content = $strManager->getHtmlSubstr($data['substr']);

        $this->assertEquals(mb_strtolower($content,mb_detect_encoding($content)), mb_strtolower($data['expected'],mb_detect_encoding($content)));
    }

    public function provider__getHtmlSubstr() {

        return array(
             
            array(array('string' => '<a>Test link</a>', 'expected' => '<a>Te...</a>', 'substr' => 2)),
            array(array(
                    'string' => '<p><span class = "new span"><a><b><img src = "http://www.google.com" class = "test_image" id = "test_id" />Test</b></a></span></p>',
                    'expected' => '<p><span class = "new span"><a><b><img src = "http://www.google.com" class = "test_image" id = "test_id" />Te...</b></a></span></p>',
                    'substr' => 2
            )),
            array(array(
                    'string' => '<b>1</b><img src = "" />HI',
                    'expected' => '<b>1</b><img src = "" />H...',
                    'substr' => 2
            )),
            array(array(
                    'string' => '<a href = "www" title = "&gt;&lt;"><img src = "www" alt="&gt;&lt;" title = "&gt;&lt;" /></a>Test',
                    'expected' => '<a href = "www" title = "&gt;&lt;"><img src = "www" alt="&gt;&lt;" title = "&gt;&lt;" /></a>Te...',
                    'substr' => 2
            )),
            array(array(
                    'string' => '<img src = "www" /><a></a>',
                    'expected' => '<img src = "www" /><a></a>',
                    'substr' => 1
            )),
            array(array(
                    'string' => '<div class = "pagination"></a><ul><li><ol><li>1</li></ol>1</li></ul></div>',
                    'expected' => '<div class = "pagination"></a><ul><li><ol><li>1</li></ol>1...</li></ul></div>',
                    'substr' => 2
            )),
            array(array(
                    'string' => '<span>></span>',
                    'expected' => '<span>>...</span>',
                    'substr' => '1'
            )),
            array(array(
                    'string' => '<iframe></iframe>',
                    'expected' => '<iframe></iframe>',
                    'substr' => '500'
            )),
            array(array(
                    'string' => '<span>33</div>asdf<span></span> adsfa   asdf</span>asdf;lj145;l234kjl45; lk23k4j6;234568023641234l;jasdfljas(*;2346j45687aw3a97645892756adsafj_)))t4io573',
                    'expected' => '<span>33</div>asdf<span></span> adsfa   asdf</span>asdf;lj145;l234kjl45; lk23k4j6;234568023641234l;jasdfljas(*;2346j45687aw3a97645892756adsafj_)))t4io573',
                    'substr' => '23456234'
            )),
            array(array(
                    'string' => '<img src = "http://www.google.com:port670" /><p></p><b><i><u>HI</u></i></b>',
                    'expected' => '<img src = "http://www.google.com:port670" /><p></p><b><i><u>H...</u></i></b>',
                    'substr' => '1'
            )),
            array(array('string' => '<span class = "super">HI</span>', 'expected' => '<span class = "super">H...</span>', 'substr' => 1)),
            array(array('string' => '<span>&amp;</span>fuck', 'expected' => '<span>&amp;</span>f...', 'substr' => 2)),
            array(array('string' => '<span>&gt;&amp;&ffuck;&gtm;</span>', 'expected' => '<span>&gt;&amp;&ffuck;&gtm;...</span>', 'substr' => 4)),
            array(array('string' => '<span class = "href = \'www.yandex.ru?cool&coll1\'">&amp;</span>', 'expected' => '<span class = "href = \'www.yandex.ru?cool&coll1\'">&amp;...</span>', 'substr' => 1)),
            array(array('string' => '<span><i></b>&gt;</i></b>&amp;&ffuck;&gtm;</span>', 'expected' => '<span><i></b>&gt;</i></b>&amp;&ffuck;&gtm;...</span>', 'substr' => '4')),
            array(array('string' => '<div title = "&gt;&">&amp;Test</div>', 'expected' => '<div title = "&gt;&">&amp;T...</div>', 'substr' => '2')),
            
            
             array(array('string' => '<p>тест</p>', 'expected' => '<p>те...</p>', 'substr' => '2')),
            
             
            array(array('string' => '<p>Еще в мае текущего года<span class="Apple-converted-space">&nbsp;</span><a style="color: #0282e4; text-decoration: underline;" href="http://allnokia.ru/news/53023/">появлялась</a><span class="Apple-converted-space">&nbsp;</span>информация, что тра та та та та</p>', 
                'expected' => '<p>Еще в мае текущего года<span class="Apple-converted-space">&nbsp;</span><a style="color: #0282e4; text-decoration: underline;" href="http://allnokia.ru/news/53023/">появлялась</a><span class="Apple-converted-space">&nbsp;</span>информация, что...</p>', 'substr' => '50')),
            
            
            );
        
         
       
    }

}

