<?php 
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

?>


<div class="admin-default-index">
    <?php foreach ($genders as $blocks) : ?>
        <div class="row">
            <?php foreach ($blocks as $name => $data) : ?>
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <?= Highcharts::widget([
                    'options' => [
                        'title'=> [
                            'text' => $name,
                            'align' => 'center',
                            'verticalAlign'=>'middle',
                            'y' => 40
                        ],
                        'chart' =>[
                            'plotBackgroundColor' => null,
                            'plotBorderWidth' => 0,
                            'plotShadow' => false
                        ],
                        'tooltip' => [
                            'pointFormat' =>'{series.name}: <b>{point.y:.1f}</b>'
                        ],
                        'plotOptions' => [
                            'pie' => [
                                'dataLabels' => [
                                    'enabled' => true,
                                    'distance' => -50,
                                    'style' => [
                                        'fontWeight' => 'bold',
                                        'color' => 'white'
                                    ]
                                ],
                                'startAngle' => -90,
                                'endAngle' => 90,
                                'center' => ['50%', '75%']
                            ]
                        ],
                        'series' => [[
                            'type' => 'pie',
                            'name' => 'Modles',
                            'innerSize' => '50%',
                            'data' => $data
                        ]]
                    ]
                ]);
            ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    
    
    <div class="row">
        <?php foreach ($total as $name => $charts) : ?>
                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <?= Highcharts::widget([
                    'options' => [
                        "chart" => ["type" => 'column'],
                        "title" => [
                            "text" => $name
                        ],
                        "subtitle" => [
                            "text" => 'Diva Dubai'
                        ],
                        "legend" => [
                            "align" => 'right',
                            "verticalAlign" => 'middle',
                            "layout" => 'vertical'
                        ],
                        "xAxis" => [
                            "categories" => $charts['list'],
                            "labels" => [
                                "x" => -10
                            ]
                        ],
                        "yAxis" => [
                            "allowDecimals" => false,
                            "title" => [
                                "text" => 'Amount'
                            ]
                        ],
                        "series" => [
                            [
                                "name" => $charts['name1'],
                                "data" => $charts['Total']
                            ], 
                            [
                                "name" => $charts['name2'],
                                "data" => $charts['Approved']
                            ]
                        ],
                        "responsive" => [
                            "rules" => [[
                            "condition" => [
                                "maxWidth" => 500
                            ],
                            "chartOptions" => [
                                "legend" => [
                                    "align" => 'center',
                                    "verticalAlign" => 'bottom',
                                    "layout" => 'horizontal'
                                ],
                                "yAxis" => [
                                    "labels" => [
                                        "align" => 'left',
                                        "x" => 0,
                                        "y" => -5
                                    ],
                                    "title" => [
                                        "text" => null
                                    ]
                                ],
                                "subtitle" => [
                                    "text" => null
                                ],
                                "credits" => [
                                    "enabled" => false
                                ]
                            ]
                                ]]
                        ]
                    ]
                ]);
                ?>
            </div>
        <?php endforeach; ?>
    </div>
    
    
<!--    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <?php 
//                = Highcharts::widget([
//                    'options' => [
//                        "chart" => [
//                            "type" => 'column'
//                        ],
//                        "title" => [
//                            "text" => 'Jobs in All Categories'
//                        ],
//                        "subtitle" => [
//                            "text" => 'Diva Dubai'
//                        ],
//                        "xAxis" => [
//                            "type" => 'category',
//                            "labels" => [
//                                "rotation" => -45,
//                                "style" => [
//                                    "fontSize" => '13px',
//                                    "fontFamily" => 'Verdana, sans-serif'
//                                ]
//                            ]
//                        ],
//                        "yAxis" => [
//                            "min" => 0,
//                            "title" => [
//                                "text" => 'Jobs (Numbers)'
//                            ]
//                        ],
//                        "legend" => [
//                            "enabled" => false
//                        ],
//                        "tooltip" => [
//                            "pointFormat" => 'Jobs In All Categories: <b></b>'
//                        ],
//                        "series" => [[
//                        "name" => 'All Jobs',
//                        "data" => [
//                                ['nicole@divadubai.com(Motor Show 2017 )', 25],
//                                ['nicole@divadubai.com(Model for Photoshoot - Female Required )', 4],
//                                ['unknown(Pakistani Fashion Week 2017)', 2],
//                                ['nicole@divadubai.com(MODEL FOR PHOTOSHOOT - MALE REQUIRED)', 9],
//                                ['book@divadubai.com(E-commerce Shoot)', 15],
//                                ['style@divadubai.com(Looking for Hair and Make Up Artist )', 2],
//                                ['nicole@divadubai.com(Dancers Required )', 5],
//                                ['tvc@divadubai.com(Fashion Show)', 21],
//                                ['activation@divadubai.com(Dubai Duty Free Promoters )', 12],
//                                ['unknown(E-Commerce Photoshoot)', 12],
//                                ['register@divadubai.com(Gala Dinner )', 14],
//                                ['nicole@divadubai.com(Choreographer Required for Fashion Show)', 18],
//                                ['style@divadubai.com(Looking for Lifestyle Photographers  )', 2],
//                                ['style@divadubai.com(Looking for Product Photographers )', 1],
//                                ['promotion@divadubai.com(Looking For Hostesses)', 11],
//                                ['unknown(DDF TOBACCO PROMOTION)', 5],
//                                ['unknown(Actors required for a Television Commercial )', 5],
//                                ['unknown(Models Required for an Indian Fashion Show)', 16],
//                                ['unknown(Tobacco Promoter)', 6],
//                                ['unknown(Dubai Motorshow Promoters)', 11],
//                                ['unknown(EUROPEAN FEMALE PROMOTERS)', 1],
//                                ['unknown(Fitting Model )', 4],
//                                ['unknown(CASTING - Korean Talent ONLY)', 0],
//                                ['unknown(CASTING  - SAUDI ARABIAN Talent Only)', 0],
//                                ['unknown(Female Model fro Abaya Shoot)', 2],
//                                ['unknown(Model for Sunglasses Shoot)', 6],
//                                ['unknown(Sporty Models for Stadium Shoot)', 13],
//                                ['unknown(CASTING - East European & Emirati Talent Only)', 5],
//                                ['unknown(Indian Looking Models fo Shoot)', 0],
//                                ['unknown(Mediterranean Looking Female Models)', 3],
//                                ['unknown(LOOKING FOR EUROPEAN MALE & FEMALE TALENTS )', 4],
//                                ['unknown(Goldwell Hair Coloring Event)', 1],
//                                ['unknown(LOOKING FOR: ARABIC LOOKING FEMALE MODEL)', 8],
//                                ['unknown(LOOKING FOR: ARABIC BOY MODELS)', 2],
//                                ['unknown(Models for Sportswear Shoot)', 8],
//                                ['unknown(Dance group Urgently Require )', 1],
//                                ['unknown(Models Required for shoot in Oman)', 3],
//                                ['unknown(Model to Interview guests at event required )', 3],
//                                ['unknown(Model to Interview guests at event required )', 4],
//                                ['unknown(LOOKING FOR EUROPEAN FEMALE MODELS FOR A TVC)', 0],
//                                ['unknown(LOOKING FOR: MALE LOOKING INDIAN MODELS)', 1],
//                                ['unknown(Photoshoot for Innerwear -European/ Med)', 2],
//                                ['unknown(Mauzan Trunk Show)', 1],
//                                ['unknown(Photoshoot for Innerwear -European/ Med)', 1],
//                                ['unknown(Make Up Demonstration)', 8],
//                                ['unknown(Fashion Show)', 10],
//                                ['unknown(LOOKING FOR HOSTESSES FOR AN EVENT ON OCT 28)', 3],
//                                ['unknown(F1 driver interview - Host required for interview)', 0],
//                                ['unknown(Female Bar Tender Required )', 0],
//                                ['unknown(Arabic Entertainment required )', 1],
//                                ['unknown(Hostess Required In Bahrain)', 2],
//                                ['unknown(Hostess Required for ADNEC)', 6],
//                                ['unknown(Required European Female and Arabic Male Promoters)', 0],
//                                ['unknown(Motor Show 2017 - male and female Model Arabic speaking required )', 2],
//                                ['unknown(Elegant African woman/ man  (thin, attractive, 40-45 years old) and kids )', 0],
//                                ['unknown(Indian woman , man and childran)', 1],
//                                ['unknown(LOOKING FOR FEMALE MODELS for a Jewelry shoot)', 5],
//                                ['unknown(Looking for Fashion Photographers who specialize in Fashion )', 0],
//                                ['unknown(Big Size Male Model )', 0],
//                                ['unknown(Arab Man, woman ,child- Family Required for photoshoot)', 4],
//                                ['unknown(REQUIRED AMERICAN HOSTESSES)', 0],
//                                ['unknown(Looking for make up bloggers)', 0],
//                                ['unknown(Required Indian Female DJ )', 0],
//                                ['unknown(Photographer requires fro Fashion Shoot )', 0],
//                                ['unknown(Model required for F1 - aarabic speaking min 175 cms)', 2],
//                                ['unknown(Arabic Speaking Model Required for Dubai World Motor Show -172cm and above)', 0],
//                                ['unknown(REQUIRED INDIAN/PAKISTANI PROMOTERS)', 3],
//                                ['unknown(LOOKING FOR MALE MODELS)', 1],
//                                ['unknown(LOOKING FOR ARAB MALE MODELS)', 0],
//                                ['unknown(Looking for Arabic / African / Indian Models for an Upcoming Resort Campaign Still Shoot)', 30],
//                                ['unknown(Model Required for F & B shoot- Arabic & Med)', 4],
//                                ['unknown(Required Sophisticated Male and femal model for Russian Magazine editorial )', 2],
//                                ['unknown(MODEL REQUIRED FOR HAIR COLOR SHOOT - 3 FEMALE)', 3],
//                                ['unknown(Female Model for Make Up Tutorial Video)', 2],
//                                ['unknown(18- 23 Year old Arab, African and Oriental Models needed for Pepsi )', 4],
//                                ['unknown(Casting Call- Virgin Mobile )', 3],
//                                ['unknown(African and European Hostesses Required for Club Activation (Alcohol Brand) )', 0],
//                                ['unknown(Models required for Ecom shoot )', 3],
//                                ['unknown(Model Required for Russian Magazine editorial )', 2],
//                                ['unknown(Models required for Hotel shoot )', 2],
//                                ['unknown(Models required for upcoming airline shoot )', 9],
//                                ['unknown(Female Models For Make Up Shoot)', 1],
//                                ['unknown(Teenage Girls Fashion Show)', 0],
//                                ['unknown(LOOKING FOR MALE AND FEMALE CASTS FOR A TVC (Role: Santa Claus and Mrs. Claus))', 0],
//                                ['unknown(Female Models for Fashion Show)', 0],
//                                ['unknown(Santa Claus & Elves)', 0]
//                        ],
//                        "dataLabels" => [
//                            "enabled" => true,
//                            "rotation" => -90,
//                            "color" => '#FFFFFF',
//                            "align" => 'right',
//                            "format" => '{point.y:.1f}', // one decimal
//                            "y" => 10, // 10 pixels down from the top
//                            "style" => [
//                                "fontSize" => '13px',
//                                "fontFamily" => 'Verdana, sans-serif'
//                            ]
//                        ]
//                            ]]
//                    ]
//                ]);
                ?>
            </div>
    </div>-->
    
     <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
             <?= Highcharts::widget([
                'options' => [
                    "chart" => [
                        "type" => 'pie'
                    ],
                    "title" => [
                        "text" => 'Subcategories of Entertainers'
                    ],
                    "subtitle" => [
                        "text" => 'Click the see the number of Subcategories selected by the Registered Users.'
                    ],
                    'plotOptions' => [
                        'series' => [
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.name}: {point.y:.0f}'
                            ]
                        ]
                    ],
                    'tooltip' => [
                        'headerFormat' => '<span style="font-size:11px">{series.name}</span><br>',
                        'pointFormat' => '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}Numbers</b> of total<br/>'
                    ],
                    'series' => [[
                        'name' => 'Brands',
                        'colorByPoint' => true,
                        'data' => $subcategoryEntertainers
                    ]],
                ]
            ]);
            ?>
        </div>
         
         
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= Highcharts::widget([
                'options' => [
                    'chart' => [
                        'type' => 'pie'
                    ],
                    'title' => [
                        'text' => 'Subcategories of Stylists'
                    ],
                    'subtitle' => [
                        'text' => 'Click to see the numbers of Subcategories Selected by the Users.'
                    ],
                    'plotOptions' => [
                        'series' => [
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.name}: {point.y:.0f}'
                            ]
                        ]
                    ],
                    'tooltip' => [
                        'headerFormat' => '<span style="font-size:11px">{series.name}</span><br>',
                        'pointFormat' => '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}Numbers</b> of total<br/>'
                    ],
                    'series' => [[
                        'name' => 'Brands',
                        'colorByPoint' => true,
                        'data' => $subcategoryStylists
                    ]],
                ]
            ]);
            ?>
        </div>
             
     </div>
    
    <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
             <?= Highcharts::widget([
                 'options' => [
                     'chart' => [
                         'type' => 'bar'
                     ],
                     'title' => [
                         'text' => ''
                     ],
                     'xAxis' => [
                         'categories' => ['Models & Promoters']
                     ],
                     'yAxis' => [
                         'min' => 0,
                         'title' => [
                             'text' => 'Total Numbers of Users'
                         ]
                     ],
                     'legend' => [
                         'reversed' => true
                     ],
                     'plotOptions' => [
                         'series' => [
                             'stacking' => 'normal'
                         ]
                     ],
                     'series' => $totalNumbers
                 ]
             ]);
             ?>
         </div>
     </div>
    
    
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                 <?= Highcharts::widget([
                    'options' => [
                        'chart' => ['type' => 'column'],
                        'title' => ['text' => $yearProgression['tite']],
                        'xAxis' => [
                           'categories' => $yearProgression['categories'],
                        ],
                        'yAxis' => [
                            'min' => 0,
                            'title' => ['text' => 'Progression in Numbers'],
                            'stackLabels' => [
                                'enabled' => true,
                                'style' => [
                                    'fontWeight' => 'bold',
                                    'color' => new JsExpression("(Highcharts . theme && Highcharts . theme . textColor) || 'gray'")
                                ]
                            ]
                        ],
                        'legend' => [
                            'align' => 'right',
                            'x' => -30,
                            'verticalAlign' => 'top',
                            'y' => 25,
                            'floating' => true,
                            'backgroundColor' => new JsExpression("(Highcharts.theme && Highcharts.theme.textColor) || 'gray'"),
                            'borderColor' => '#CCC',
                            'borderWidth' => 1,
                            'shadow' => false
                        ],
                        'tooltip' => [
                            'headerFormat' => '<b>{point.x}</b><br/>',
                            'pointFormat' => '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                        ],
                        'plotOptions' => [
                            'column' => [
                                'stacking' => 'normal',
                                'dataLabels' => [
                                    'enabled' => true,
                                    'color' => new JsExpression("(Highcharts . theme && Highcharts . theme . dataLabelsColor) || 'white'")
                                ]
                            ]
                        ],
                        'series' => $yearProgression['data']
                     ]
                 ]);
                 ?>
             </div>
         </div>
    
    
    <div class="col-sm-12 col--md-12 col-xs-12">
        <a href="/admin/user"><div class="booker">Year Progression Graph as per Each Booker</div></a>
   </div>
    <div class="col-sm-12 col--md-12 col-xs-12">
        <div class="col-sm-3 col-md-3 col-xs-12">
            <div style="background-color: #404040;box-shadow: 1px 1px 1px 1px #d3d3d3;text-align: center; height: 116px;">
                <i class="fa fa-user" aria-hidden="true" style="font-size: 20px; text-align: center; padding: 39px; color: #d3d3d3;"><span>
                        Admin-Panel Users:
                    </span><span>19</span></i>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-xs-12">
            <div style="background-color: #404040;box-shadow: 1px 1px 1px 1px #d3d3d3;text-align: center; height: 116px;">
                <i class="fa fa-trophy" aria-hidden="true" style="font-size: 20px; text-align: center; padding: 39px; color: #d3d3d3;"><span>
                        Awards:
                    </span><span>25</span></i>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-xs-12">
            <div style="background-color: #404040;box-shadow: 1px 1px 1px 1px #d3d3d3;text-align: center; height: 116px;">
                <i class="fa fa-briefcase" aria-hidden="true" style="font-size: 20px; text-align: center; padding: 39px; color: #d3d3d3;"><span>
                        Jobs:
                    </span><span>86</span></i>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-xs-12">
            <div style="background-color: #404040;box-shadow: 1px 1px 1px 1px #d3d3d3;text-align: center; height: 116px;">
                <i class="fa fa-magnet" aria-hidden="true" style="font-size: 20px; text-align: center; padding: 39px; color: #d3d3d3;"><span>
                        Applications:
                    </span><span>401</span></i>
            </div>
        </div>
    </div>
    
</div>


