<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace LINE\LINEBot\MessageBuilder;

use LINE\LINEBot\Constant\MessageType;
use LINE\LINEBot\MessageBuilder;

/**
 * A builder class for text message.
 *
 * @package LINE\LINEBot\MessageBuilder
 */
class weather implements MessageBuilder
{
    /** @var string[] */
    private $texts;
    /** @var array */
    private $message = [];
    private $location;

    /**
     * TextMessageBuilder constructor.
     *
     * Exact signature of this constructor is <code>new TextMessageBuilder(string $text, string[] $extraTexts)</code>.
     *
     * Means, this constructor can also receive multiple messages like so;
     *
     * <code>
     * $textBuilder = new TextMessageBuilder('text', 'extra text1', 'extra text2', ...);
     * </code>
     *
     * @param string $text
     * @param string[]|null $extraTexts
     */
 public function __construct($location)
    {
        $this->location = $location;
          //query=[Taipei];//，例如: Taoyuan Air Base , Taipei
    $xml = simplexml_load_file(
        "http://api.wunderground.com/auto/wui/geo/WXCurrentObXML/index.xml?query=$location"
    );


    
    $wea=$xml->weather;

    
    $tem=$xml->temp_c;

    $mus=$xml->relative_humidity;

    $wind=$xml->wind_dir;
   //date_default_timezone_set('Asia/Taipei');
   $time = date(
        'Y-m-d H:i',
        strtotime($xml->local_time)
    );
     
    if($wea=="thunderstorm rain"){ $wea= "雷雨  ";}
    if($wea=="light showers rain"){ $wea= "小驟雨 ";}
    if($wea=="flurries"){ $wea= "小雪  ";}
    if($wea=="Cloudy"){ $wea= "霧   ";}
    if($wea=="Haze"){ $wea= "陰霾  ";}
    if($wea=="Mostly Cloudy"){ $wea= "多雲時陰";}
    if($wea=="Mostly Sunny"){ $wea= "晴時多雲";}
    if($wea=="Partly Cloudy"){ $wea= "局部多雲";}
    if($wea=="Partly Sunny"){ $wea= "多雲時晴";}
    if($wea=="thunderstorm rain"){ $wea= "凍雨";}
    if($wea=="Rain"){ $wea= "雨   ";}
    if($wea=="Sleet"){ $wea= "冰雹  ";}
    if($wea=="Snow"){ $wea= "雪   ";}
    if($wea=="Sunny"){ $wea= "晴朗  ";}
    if($wea=="Unknown"){ $wea= "未知  ";}
    if($wea=="Overcast"){ $wea= "陰天  ";}
    if($wea=="Scattered Clouds"){ $wea= "疏雲  ";}
    
   $this->text = '氣象狀況：'.$wea.'        溫度：'.$tem.'           相對濕度： '.$mus.'                風向： '.$wind.'                  時間：'.$time;
   
    /*
    showers rain = 驟雨
    light showers rain = 小驟雨

    Cloudy = 多雲
    Flurries = 小雪
    Fog = 霧
    Haze = 陰霾
    Mostly Cloudy = 多雲時陰
    Mostly Sunny = 晴時多雲
    Partly Cloudy = 局部多雲
    Partly Sunny = 多雲時晴
    Freezing Rain = 凍雨
    Rain = 雨
    Sleet = 冰雹
    Snow = 雪
    Sunny = 晴朗
    Unknown = 未知
    Overcast = 陰天
    Scattered Clouds = 疏雲 
    */
   
   
   

        
    
    
        
        
        
        
        
    }

    /**
     * Builds location message structure.
     *
     * @return array
     */




public function buildMessage()
    {
        return [
            [
                'type' => MessageType::TEXT,
                'text' => $this->text,
                
            ]
        ];
    }
}