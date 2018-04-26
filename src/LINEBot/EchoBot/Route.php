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

namespace LINE\LINEBot\EchoBot;

use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Exception\UnknownEventTypeException;
use LINE\LINEBot\Exception\UnknownMessageTypeException;

class Route
{
    public function register(\Slim\App $app)
    {
        $app->post('/callback', function (\Slim\Http\Request $req, \Slim\Http\Response $res) {
            /** @var \LINE\LINEBot $bot */
            $bot = $this->bot;
            /** @var \Monolog\Logger $logger */
            $logger = $this->logger;

            $signature = $req->getHeader(HTTPHeader::LINE_SIGNATURE);
            if (empty($signature)) {
                return $res->withStatus(400, 'Bad Request');
            }

            // Check request with signature and parse request
            try {
                $events = $bot->parseEventRequest($req->getBody(), $signature[0]);
            } catch (InvalidSignatureException $e) {
                return $res->withStatus(400, 'Invalid signature');
            } catch (UnknownEventTypeException $e) {
                return $res->withStatus(400, 'Unknown event type has come');
            } catch (UnknownMessageTypeException $e) {
                return $res->withStatus(400, 'Unknown message type has come');
            } catch (InvalidEventRequestException $e) {
                return $res->withStatus(400, "Invalid event request");
            }

           
        foreach ($events as $event) {
        	// Postback Event
        	if (($event instanceof \LINE\LINEBot\Event\PostbackEvent)) {
        		$logger->info('Postback message has come');
        		continue;
        	}
        	// Location Event
        	if  ($event instanceof LINE\LINEBot\Event\MessageEvent\LocationMessage) {
        		$logger->info("location -> ".$event->getLatitude().",".$event->getLongitude());
        		continue;
        	}
        	// Message Event = TextMessage
        	if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
        		$messageText=strtolower(trim($event->getText()));
        		switch ($messageText) {
        	
        	    case "天氣":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("打各地地名阿");
        	    case "ysf":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("YAMAHA SECURITY FORCE your best choice!!");
            		    break;
                case "馬英九":
                        $img_url = "https://upload.wikimedia.org/wikipedia/commons/e/e4/%E4%B8%AD%E8%8F%AF%E6%B0%91%E5%9C%8B%E7%AC%AC12%E3%80%8113%E4%BB%BB%E7%B8%BD%E7%B5%B1%E9%A6%AC%E8%8B%B1%E4%B9%9D%E5%85%88%E7%94%9F%E5%AE%98%E6%96%B9%E8%82%96%E5%83%8F%E7%85%A7.jpg";
            			$outputText = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
            			break;
            			
        	    case "勝發":
            		    
            		    
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("你覺得他率嗎");
            		    break;
                case "欸":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("幹嘛?");
                case "葉":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("勝發");
            		    break;
                case "欸欸":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("幹嘛?");
            		    break;
        	    case "沒事":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("ㄈ");
            		    break;
        	     case "幹嘛":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("沒事");
            		    break;
                 case "?":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("沒事");
            		    break;
            	case "幹嘛?":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("沒事");
            		    break;
        	    case  "ㄈ":
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("ㄈ");
            		    break;
        		case "date":
            		    
            		    date_default_timezone_set('Asia/Taipei');
            		    $s1 = date('Y-m-d');
            		    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("$s1");
            		    break;
        		
        		case "台北":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("taipei");
        		        
        		        break;
        		
        		case "高雄":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("kaohsiung");
        		        
        		        break;
        		
        		case "台南":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("tainan");
        		        
        		        break;
        		
        		case "台中":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("taichung");
        		        
        		        break;
        		
        		case "新竹":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("hsinchu");
        		        
        		        break;
        		case "嘉義":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("chiayi");
        		        
        		        break;
        		case "宜蘭":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("宜蘭");
        		        
        		        break;
        		case "台東":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("台東市");
        		        
        		        break;
        		case "苗栗":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("Miaoli");
        		        
        		        break;
        		case "彰化":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("Changhua");
        		        
        		        break;
        		case "屏東":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("Pingtung%20North");
        		        
        		        break;
        		case "花蓮":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("台東市");
        		        
        		        break;
        		case "雲林":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("Yunlin");
        		        
        		        break;
        		case "南投":
        		        $outputText = new \LINE\LINEBot\MessageBuilder\weather("Nantou");
        		        
        		        break;
        		case"infor":
        	            
        	            
        	            $in = "Cloudy = 多雲  Flurries = 小雪  Fog = 霧  Haze = 陰霾  Mostly Cloudy = 多雲時陰  Mostly Sunny = 晴時多雲  Partly Cloudy = 局部多雲  Partly Sunny = 多雲時晴   Freezing Rain = 凍雨   Rain = 雨  Sleet = 冰雹  Snow = 雪  Sunny = 晴朗  Unknown = 未知  Overcast = 陰天     Scattered Clouds = 疏雲"; 
        	            
        	            $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("$in");
        		        
        		        
        		         break;
        		
        		
        		case "location" :
        			$outputText = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder("ellel tower", "Champ de Mars, 5 Avenue Anatole France, 75007 Paris, France", 48.858328, 2.294750);
        			break;
        		case "button" :
        			$actions = array (
                        //New \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder("按", "hsinchu"),
        				// general message action
        				New \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("看詳細","https://www.wunderground.com/q/zmw:00000.1.46756"),
        				// URL type action
        				New \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("旅遊資訊","http://tourism.hccg.org.tw/index.php")
        				// The following two are interactive actions
        				
        			);
        			$img_url = "https://house.udn.com/magimages/48/PROJ_ARTICLE/423_4153/f_261948_1.jpg";
        			$button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("新竹", "hsinchu", $img_url, $actions);
        			$outputText = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("this message to use the phone to look to the Oh", $button);
        			break;
        		
        		
        		case "door" :
        			$columns = array();
        			$img_url1 = "https://pix10.agoda.net/hotelImages/100/100114/100114_13110808530017353420.jpg?s=312x235&ar=16x9";
        			$img_url2 = "https://www.cathaypacific.com/content/dam/focal-point/digital-library/destinations/taipei-tpe/Taipei_TPE_101_skyline_day_offer.jpg/jcr:content/renditions/cq5dam.rendition.900.450.jpg";
        			$img_url3 = "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/%E5%8F%B0%E5%8D%97_%E8%B5%A4%E5%B4%81%E6%A8%93.jpg/220px-%E5%8F%B0%E5%8D%97_%E8%B5%A4%E5%B4%81%E6%A8%93.jpg";
        			$img_url4 = "https://photo.network.com.tw/scenery/BF2F324D-027D-476C-8A49-A73793BE50E9_c.jpg";
        			$img_url5 = "https://house.udn.com/magimages/48/PROJ_ARTICLE/423_4153/f_261948_1.jpg";
        			
        			
        				$actions = array(
        					new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("看詳細","https://www.wunderground.com/global/stations/46740.html"),
        				    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("旅遊資訊","http://khh.travel/")
        				);
        				$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("高雄天氣", "kaohsiung", $img_url1 , $actions);
        				$columns[0] = $column;
        				
        			    $actions = array(
        					new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("看詳細","https://www.wunderground.com/cgi-bin/findweather/getForecast?query=taipei"),
        				    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("旅遊資訊","https://www.travel.taipei/")
        				);
        				$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("台北天氣", "taipei", $img_url2 , $actions);
        				$columns[1] = $column;
        			    
        			    $actions = array(
        					new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("看詳細","https://www.wunderground.com/global/stations/59358.html"),
        				    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("旅遊資訊","https://www.twtainan.net/")
        				);
        				$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("台南天氣", "tainan", $img_url3 , $actions);
        				$columns[2] = $column;
        			    
        			    $actions = array(
        					new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("看詳細","https://www.wunderground.com/global/stations/59158.html"),
        				    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("旅遊資訊","http://travel.taichung.gov.tw/")
        				);
        				$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("台中天氣", "taichung", $img_url4 , $actions);
        				$columns[3] = $column;
        				
        				$actions = array(
        					new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("看詳細","https://www.wunderground.com/q/zmw:00000.1.46756"),
        				    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("旅遊資訊","http://tourism.hccg.org.tw/index.php")
        				);
        				$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("新竹天氣", "hsinchu", $img_url5 , $actions);
        				$columns[4] = $column;
        			
        			
        			
        			$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
        			$outputText = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("Carousel Demo", $carousel);
        			break;	
        		
        		
        		
        		
        		
        		case "image" :
        			$img_url = "https://cdn2.ettoday.net/images/1685/d1685544.jpg";
        			$outputText = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
        			break;	
        		case "confirm" :
        			$actions = array (
        				New \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("yes", "ans=y"),
        				New \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("no", "ans=N")
        			);
        			$button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder("you sure?", $actions);
        			$outputText = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("this message to use the phone to look to the Oh", $button);
        			break;
        		default :
        			$a=rand(0,3);
        			if($a==0){
        			    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("哈囉");	
        			    
        			}else if ($a==1){
            			$img_url = "https://cdn2.ettoday.net/images/1685/d1685544.jpg";
            			$outputText = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
        			    
        			}else if ($a==2){
        			    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("對啊");
        			}else if ($a==3){
        			    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("好");
        			}
        			
        			break;
        		}
        		$response = $bot->replyMessage($event->getReplyToken(), $outputText);
        	}
        }  

            $res->write('OK');
            return $res;
        });
    }
}
