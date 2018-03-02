<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FilterForm extends Model
{
    public $name;
    public $ethnicity;
    public $specialization;
    public $age;
    public $gender;
    public $language;
    public $length;
    
    public $subcategory;
    public $sub;
    
    public $_ethnicity;
    public $_specialization;
    public $_category;
    public $_language;
    public $_gender;
    public $_AGE;
    public $action;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'ethnicity', 'specialization', 'subcategory', 'age', 'language', 'gender'], 'string', 'max' => 255],
        ];
    }
    
    public function setForm($type){
        $this->action = $type;

        $blockKilter = ModelCategory::getBlockFilltersForCategory($type);
        
//        vd($blockKilter);

        if($blockKilter){
            $this->_ethnicity       = ($blockKilter['ethnicity'] == '1')        ? UserInfo::itemAlias('ethnicity') : null;
            $this->_specialization  = ($blockKilter['specialization'] == '1')   ? UserInfo::itemAlias('specialization') : null;
            $this->_gender          = ($blockKilter['gender'] == '1')           ? UserInfo::itemAlias('gender') : null;
            $this->_language        = ($blockKilter['language'] == '1')         ? UserInfo::itemAlias('language') : null;
            $this->_category        = ($blockKilter['category'] == '1')         ? ModelSubcategory::getListSubcategoryForCategory($type, 'Category') : null;
            
            if($blockKilter['age'] == '1'){
                $gender = Yii::$app->request->get('gender');
                if(in_array($gender, ['boy', 'girl'])){
                    $this->_AGE['AGE'] =  UserInfo::itemAlias('age-children');
                }else{
                    $this->_AGE['AGE'] =  UserInfo::itemAlias('age');
//                    $this->_AGE =  ModelSubcategory::getListSubcategoryForCategory('age', 'AGE');
                }
            }
            
        }
        
//        vd($this->_gender);

        
        $this->length =   (int)$this->_ethnicity 
                        + (int)$this->_specialization 
                        + (int)$this->_gender 
                        + (int)$this->_category 
                        + (int)$this->_AGE;
    }
    
    public static function itemSubcategory($type = false, $code = false) {
        $_items = [
            'Models' => [
                'celebrity' => 'Celebrity',
                'direct-booking' => 'Direct Booking',
                'international' => 'International',
                'model1' => 'model1',
                'model2' => 'model2',
                'new-face' => 'New Face',
                'out-of-town' => 'Out of Town',
                'protfolio' => 'Protfolio',
                
            ],
            'Promoters Activations' => [
                'actor' => 'Actor',
                'alcohol' => 'Alcohol',
                'automobile' => 'Automobile',
                'beauty' => 'Beauty',
                'cigarettes' => 'Cigarettes',
                'duty-free' => 'Duty Free',
                'electronics' => 'Electronics',
                'food' => 'Food',
                'fmcg' => 'FMCG',
                'hands-feet' => 'Hands & Feet',
                'host' => 'Host',
                'hostess' => 'Hostess',
                'out-of-town' => 'Out of Town',
                'promoter-1' => 'Promoter 1',
                'promoter-2' => 'Promoter 2',
                'supermarket' => 'Supermarket',
            ],
            "Stylist" => [
                "Makeup Stylist" => "Makeup Stylist",
                "Hair Stylist" => "Hair Stylist",
                "Hair and Make" => "Hair and Make up",
                "Prosthetic Stylist" => "Prosthetic Stylists",
                "Wardrobe Stylist" => "Wardrobe Stylist",
                "Prop Stylist" => "Prop stylist",
                "Food Stylist" => "Food Stylist",
                "Out of Town" => "Out of Town",
            ],
            'Events' => [
                "3d-modelling" => "3D Modelling", 
                "agencies"=>"Agencies",
                "awards"=>"Awards", 
                "brand-ambasador" => "Brand Ambasador",
                "corporate-gifts"=>"Corporate Gifts", 
                "dj-equiment"=>"DJ Equiment",
                "catering"=>"Catering", 
                "event-organizer"=>"Event Organizer",
                "exhibition-stan"=>"Exhibition Stan", 
                "fireworks"=>"Fireworks",
                "florists"=>"Florists", 
                "helpers"=>"Helpers",
                "Kids"=>"Kids", 
                "food-blogger"=>"Food Blogger",
                "pro"=>"PRO", 
                "fashion-blogger"=>"Fashion Blogger",
                "security"=>"security", 
                "set-designs-dec"=>"Set Designs/Dec",
                "stage-sounds"=>"Stage/Sounds/", 
                "tailor"=>"Tailor",
                "tents"=>"Tents", 
                "translators"=>"Translators",
                "videographers"=>"Videographers", 
                "wedding-decor"=>"Wedding Decor",
                'hands-Feet' => 'Hands & Feet', 
                'out-of-town' => 'Out of Town',
                'plus-size-model' => 'Plus Size Model',
            ],
            'Cast' => [
                'hands-Feet' => 'Hands & Feet',
                'out-of-town' => 'Out of Town',
                'plus-size-model' => 'Plus Size Model',
            ],
            'AGE' => [
                'hands-Feet' => 'Hands & Feet',
                'out-of-town' => 'Out of Town',
                'plus-size-model' => 'Plus Size Model',
            ],
            'Entertainers'=>[
                "3d-modelling"=>"3D Modelling",
                "acrobats"=>"Acrobats",
                "actors"=>"Actors",
                "balloon-twister"=>"Balloon Twister",
                "bar-tenders"=>"Bar Tenders",
                "belly-dancer"=>"Belly Dancer",
                "calligrapher"=>"Calligrapher",
                "caricature-artists"=>"Caricature Artists",
                "carnival-activities"=>"Carnival Activities",
                "cheerledders"=>"cheerledders",
                "chefs"=>"Chefs",
                "clowns-jugglers"=>"Clowns/Jugglers",
                "choreographer"=>"Choreographer",
                "comedians"=>"Comedians",
                "dancers-arabic"=>"Dancers-Arabic",
                "dancers-ballet"=>"Dancers-Ballet",
                "dancers-bolly"=>"Dancers Bolly",
                "dancers-bubble"=>"Dancers- Bubble",
                "dancers-carnival"=>"Dancers-Carnival",
                "dancers-contemporary"=>"Dancers-Contemporary",
                "dancers-cultr"=>"Dancers - Cultr",
                "dancers-fire"=>"Dancers-Fire",
                "dancers-hh-str"=>"Dancers- HH/STR",
                "dancers-latin"=>"Dancers-Latin",
                "dancers-led"=>"Dancers- Led",
                "djs"=>"Djs",
                "drummer"=>"Drummer",
                "e-companies"=>"E Companies",
                "extreme-sports"=>"Extreme Sports",
                "face-painters"=>"Face Painters",
                "fs-choreographe"=>"FS Choreographe",
                "graffiti"=>"Graffiti",
                "henna-artists"=>"Henna Artists",
                "human-statues"=>"Human Statues",
                "hypnotist"=>"Hypnotist",
                "magicians"=>"Magicians",
                "mascots"=>"Mascots",
                "mimic-artist"=>"Mimic Artist",
                "mixologist"=>"Mixologist",
                "motivational-speaker"=>"Motivational Speaker",
                "musicians"=>"Musicians",
                "out-of-town"=>"Out of Town",
                "parkour"=>"Parkour",
                "pole-dancers"=>"Pole Dancers",
                "rice-artist"=>"Rice Artist",
                "sand-artists"=>"Sand Artists",
                "singers"=>"Singers",
                "speed-painter"=>"Speed Painter",
                "sports"=>"Sports",
                "stilt-walkers"=>"Stilt Walkers",
                "unicyclists"=>"Unicyclists",
                "voice-overs"=>"Voice Overs",
            ],
            "CATEGORY A"=>["International" => "International"],  
            "CATEGORY B"=>[
                "Advertising"=>"Advertising",
                "Beauty"=>"Beauty",
                "EditorialP"=> "EditorialP",
                "Fashion"=>"Fashion",
                "Hair"=>"Hair",
                "Jewellery"=>"Jewellery",
                "Lifestyle"=>"Lifestyle",
            ],
            "CATEGORY C"=>[
                "product-still-life"=>"Product / Still Life",
                "FoodP"=>"FoodP",
            ],
            "CATEGORY D"=>[
                "Sports"=>"Sports",
                "Events"=>"Events",
            ],
            "CATEGORY E"=>[
                "Hotel"=>"Hotel",
                "Landscape"=>"Landscape",
                "Interior Arch"=>"Interior / Arch",
                "Aerial"=>"Aerial",
            ],
            "CATEGORY F"=>["Children"=>"Children"],
            "CATEGORY G"=>["Wedding"=>"Wedding"],
            "CATEGORY H"=>["Car"=>"Car"],
            "CATEGORY I"=>["Portrait"=>"Portrait"],
            "CATEGORY J"=>[
                "Underwater Photography"=>"Underwater Photography",
            ],
            'Director'=> [
                "Assistant Director"=>"Assistant Director",
                "director"=>"Director",
                "Director Of Photography"=>"Director Of Photography",
            ],
           "Locations"=>[
                "Airplane"=>"Airplane",                                                               
                "Apartments"=>"Apartments",                                                                
                "Arab architecture"=>"Arab architecture",                                                                
                "Ballrooms"=>"Ballrooms",                                                                
                "Bars"=>"Bars",                                                                
                "Bathrooms"=>"Bathrooms",                                                                
                "Beaches"=>"Beaches",                                                                
                "Bedrooms"=>"Bedrooms",                                                                
                "Cafes"=>"Cafes",                                                                
                "Construction Site"=>"Construction Site",                                                                
                "Dance venue"=>"Dance venue",
                "Deserts"=>"Deserts",                                                                
                "Farms"=>"Farms",                                                                
                "Fields"=>"Fields",                                                                
                "Fountains"=>"Fountains",                                                                
                "Galleries"=>"Galleries",                                                                
                "Gardens"=>"Gardens",                                                                
                "Hospitals"=>"Hospitals",                                                                
                "Hotels"=>"Hotels",                                                                
                "Interioirs-european"=>"Interioirs-european",                                                                
                "Interiors-arabic"=>"Interiors-arabic",                                                                
                "Kitchens"=>"Kitchens",                                                                
                "Lakes"=>"Lakes",                                                                
                "Landscapes"=>"Landscapes",                                                                
                "Malls"=>"Malls",                                                                
                "Modern buildings"=>"Modern buildings",                                                                
                "Nurseries"=>"Nurseries",                                                                
                "Offices"=>"Offices",                                                                
                "Parks"=>"Parks",                                                                
                "Resturants"=>"Resturants",                                                                
                "Roads"=>"Roads",                                                                
                "Roofs"=>"Roofs",                                                                
                "Schools"=>"Schools&amp;Colleges",
                "Souks"=>"Souks",
                "Spas"=>"Spas",
                "Sports Venues"=>"Sports Venues",
                "Stables"=>"Stables",
                "Stairs"=>"Stairs",
                "Studios"=>"Studios",
                "swimming Pools"=>"Swimming Pools",
                "Terraces"=>"Terraces",
                "Villas"=>"Villas",
                "Yachts-Boats"=>"Yachts/Boats",
            ],
            "Post Production"=>[
                "3D Animation"=>"3D Animation",
                "Animals"=>"Animals",
                "Art Director"=>"Art Director",
                "Branding"=>"Branding",
                "Brochures-Invitaion"=>"Brochures &amp; Invitaion",
                "Caravan"=>"Caravan",
                "Catering Servc"=>"Catering Servc",
                "Copywriting &amp; proof reading"=>"Copywriting &amp; proof reading",
                "Creative Director"=>"Creative Director",
                "Equip Rentals"=>"Equip Rentals",
                "Graphic Designer"=>"Graphic Designer",
                "International"=>"International",
                "Music Prod"=>"Music Prod",
                "Post Production Services"=>"Post Production Services",
                "Printing"=>"Printing",
                "Retoucher"=>"Retoucher",
                "Set Designer"=>"Set Designer",
                "Signage-ATL-BTL"=>"Signage/ATL/BTL",
                "Studio Rental"=>"Studio Rental",
            ],
            'Promoters'=>[
                "Host"=>"Host",
                "Hostess"=>"Hostess",
                "out-of-town"=>"Out of town",
                "promoter-1"=>"Promoter 1",
                "promoter-2"=>"Promoter 2",
                "actor"=>"Actor",
                "hands-feet"=>"Hands &amp; Feet",
                "alcohol"=>"Alcohol",
                "Automobile"=>"Automobile",
                "beauty"=>"Beauty",
                "cigarettes"=>"Cigarettes",
                "duty-free"=>"Duty Free",
                "electronics"=>"Electronics",
                "food"=>"Food",
                "fmcg"=>"FMCG",
                "supermarket"=>"Supermarket",
            ],
           
        ];
        
        if($type == false){
            return $_items;
        }elseif($code == false){
            return isset($_items[$type]) ? $_items[$type] : [];
        }elseif($code != null){
            return isset($_items[$type][$code]) ? $_items[$type][$code] : [];
        }else{
            return []; 
        }
    }
    
    public static function getNameSubcategory($subcategory){
        $array = self::itemSubcategory();
        
        if($subcategory !== '0'){
            foreach ($array as $value) {
                foreach ($value as $kay => $item) {
                    if($kay === $subcategory){
                        return $item;
                    }
                }
            }
        }
        return '(not set)';
    }

        
    public static function saveSubcategory($oldsubcategory, $types, $subcategory){
        $oldsubcategory = ($oldsubcategory != '') ? json_decode($oldsubcategory) : [];
        
        $added = true;
        foreach ($types as $key => $value) {
            $allSubcategory = self::itemSubcategory($value);
            
            if($subcategory !== '0' && isset($allSubcategory[$subcategory])){
                foreach ($oldsubcategory as $i => $item) {
                    if(isset($allSubcategory[$item])){
                        $oldsubcategory[$i] = $subcategory;
                        $added = false; 
                    }
                }
            }else{
                
            }
        }
        
        if($added){
            $oldsubcategory[] = $subcategory;
        }
        
       return $oldsubcategory;
    }
    
    public static function getListUnite($types){
        $result = [];
        foreach ($types as $key => $value) {
            $result[ucfirst($value)] = self::itemSubcategory($value);
        }
        return $result;
    }
}