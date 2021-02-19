<?php

namespace frontend\controllers;

use app\models\TgConfig;
use Yii;

use frontend\models\ImgsToAddresses;
use frontend\models\ImgToAddresses;
use frontend\models\Products;
use frontend\models\Packages;
use frontend\models\Eds;
use frontend\models\Cities;
use frontend\models\Regions;
use frontend\models\Clients;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use frontend\models\LoginForm;
use frontend\models\User;
use frontend\models\SignupForm;
use frontend\models\Addresses;
use yii\helpers\ArrayHelper;
use frontend\models\UploadForm;
use frontend\models\Adjustment;
use frontend\models\CitiesToUsers;
use yii\web\UploadedFile;




class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect('site/stats');
        } else {
            return $this->redirect('site/login');
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {

        $user = new User();

        $model = new SignupForm();
        $cities = new Cities();
        $ctu = new CitiesToUsers();
        if($model->load(Yii::$app->request->post()) && $model->validate()   ){
            $user->password = $model->password;
            $user->username = $model->username;
            $user->role_id = '2';
            if($user->save()){
               foreach (Yii::$app->request->post()['CitiesToUsers']['city_id'] as $city) {
                   $ctu = new CitiesToUsers();
                   $ctu->city_id = $city;
                   $ctu->user_id = $user->id;
                   $ctu->save();
               }
               $this->redirect(['/site/login']);
            }
        }

        return $this->render('signup', compact('model', 'cities', 'ctu'));
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionClients()
    {
        $clients = Clients::find()->all();

        return $this->render('clients', compact('clients'));
    }

    public function actionRemoveclients($id)
    {
        if (Yii::$app->user->identity->role_id == 1) {


            $oneclient = Clients::findOne($id);
            $oneclient->delete();

            return $this->redirect('clients');
        } else {
            return $this->goHome();
        }
    }

    public function actionCities($idedit = null)
    {

        if (Yii::$app->user->identity->role_id == 1) {


            $buttonname = 'Добавить';
            $cities = Cities::find()->all();

            if ($idedit) {
                $buttonname = 'Редактировать';
                $model = Cities::findOne($idedit);
                if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                    return $this->redirect('cities');
                }
                return $this->render('cities', compact('cities', 'model', 'buttonname'));
            }
            $model = new Cities();

            if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                return $this->redirect('cities');
            }

            return $this->render('cities', compact('cities', 'model', 'buttonname'));
        } else {
            return $this->goHome();
        }
    }

    public function actionUsers()
    {
        $users = User::find()->all();

        return $this->render('users', compact('users'));
    }

//    public function actionAdjustment()
//    {
//        $adjustment = Adjustment::find()->one();
//
//        if($model = $adjustment) {
//
//            if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
//                return $this->redirect('adjustment');
//            }
//        }
//
//        return $this->render('adjustment', compact('model', 'adjustment'));
//    }



    public function actionRemovecities($id)
    {
        if (Yii::$app->user->identity->role_id == 1) {


            $onecity = Cities::findOne($id);
            $onecity->delete();

            return $this->redirect('cities');
        } else {
            return $this->goHome();
        }
    }



    public function actionProducts($idedit = null)
    {

        if (Yii::$app->user->identity->role_id == 1 || Yii::$app->user->identity->role_id == 2) {


            $buttonname = 'Добавить';
            $products = Products::find()->all();
            $cities = Cities::find()->all();
            $items_city = ArrayHelper::map($cities,'id','name');
            $eds = Eds::find()->all();
            $items_ed = ArrayHelper::map($eds,'id','type');;

            $ctu = CitiesToUsers::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
            if ($idedit) {
                $buttonname = 'Редактировать';
                $model = Products::findOne($idedit);
                if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                    return $this->redirect('products');
                }
                return $this->render('products', compact('products', 'model', 'buttonname', 'items_city', 'items_ed'));
            }
            $model = new Products();

            if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                return $this->redirect('products');
            }

            return $this->render('products', compact('products', 'model', 'buttonname', 'items_city', 'items_ed', 'ctu'));
        } else {
            return $this->goHome();
        }
    }

    public function actionRemoveproducts($idremove)
    {
        if (Yii::$app->user->identity->role_id == 1) {

            $oneproduct = Products::findOne($idremove);
            /*$addresses
            for ($i = 0; $i < count($addresses); $i++) {
                $addresses[$i]->delete();
            }*/
            $oneproduct->delete();

            return $this->redirect('products');
        } else {
            return $this->goHome();
        }
    }

    public function actionPackages($product_id , $idedit = null)
    {

        $buttonname = 'Добавить';
        $packages = Packages::find()->where('product_id='.$product_id)->all();
        if ($idedit) {
            $buttonname = 'Редактировать';
            $model = Packages::findOne($idedit);
            if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                return $this->redirect('packages?product_id='.$product_id);
            }
            return $this->render('packages', compact('packages', 'model', 'buttonname', 'product_id'));
        }
        $model = new Packages();
        if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
            return $this->redirect('packages?product_id='.$product_id);
        }
        return $this->render('packages', compact('packages', 'model', 'buttonname', 'product_id'));

    }

    public function actionAddresses($package_id , $idedit = null)
    {

        if (Yii::$app->user->identity->role_id == 1 || Yii::$app->user->identity->role_id == 2) {


            $buttonname = 'Добавить';
            $addresses = Addresses::find()->where('package_id=' . $package_id)->all();
            $cityId = Packages::find()->where(['id' => $package_id])->one()->product->city_id;
            $regions = Regions::find()->where(['city_id' => $cityId])->all();
//            $ctu = CitiesToUsers::find()->where(['user_id' => Yii::$app->user->identity->id])->all();

            $items_region = ArrayHelper::map($regions,'id','name');
            $model = new Addresses();
            $picturemodel = new ImgsToAddresses();

            if ($idedit) {
				$buttonname = 'Редактировать';
				$model = Addresses::findOne($idedit);
				if ($model->load(Yii::$app->request->post())) {
					if ($picturemodel->load(Yii::$app->request->post())) {
						$picturemodel->img = UploadedFile::getInstances($picturemodel, 'img');
						if (count($picturemodel->img) > 0) {
						    $picturemodel2 = ImgsToAddresses::find()->where(['address_id' => $idedit])->all();
						    foreach ($picturemodel2 as $picture) {
								$picture->delete();
							}
							$picturemodel->uploadmulti($idedit, $package_id);
						}
					}
					$model->save();
					return $this->redirect('addresses?package_id=' . $package_id);
				}
				return $this->render('addresses', compact('addresses', 'model', 'buttonname', 'package_id', 'items_region', 'picturemodel'));
			}


            if ($model->load(Yii::$app->request->post())) {
                $model->created_at = date('Y-m-d');
                $model->save();
                $address_id = $model->id;
            }

            if ($picturemodel->load(Yii::$app->request->post())) {
                $picturemodel->img = UploadedFile::getInstances($picturemodel, 'img');
                $picturemodel->uploadmulti($address_id, $package_id);

                return $this->redirect('addresses?package_id='.$package_id);

            }

            return $this->render('addresses', compact('addresses', 'model', 'buttonname', 'package_id', 'items_region', 'picturemodel'));
        } else {
            return $this->goHome();
        }
    }

    /*public function actionAddresspage($address_id , $idedit = null)
    {

        if (Yii::$app->user->identity->role_id == 1 || Yii::$app->user->identity->role_id == 2) {



            $address = Addresses::find()->where('address_id=' . $address_id)->one();

            if ($idedit) {
                $buttonname = 'Редактировать';
                $model = Addresses::findOne($idedit);
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect('packages?product_id=' . $product_id);
                }
                return $this->render('addresses', compact('addresses', 'model', 'buttonname', 'package_id', 'items_region'));
            }
            $model = new Addresses();


            if ($model->load(Yii::$app->request->post())) {
                $model->save();
                $address_id = $model->id;
            }

            $picturemodel = new ImgsToAddresses();

            if ($picturemodel->load(Yii::$app->request->post())) {
                $picturemodel->img = UploadedFile::getInstances($picturemodel, 'img');

                foreach ($picturemodel as $picture) {
                    if ($picture->img !== null) {
                        $picture->img->saveAs('uploads/' . $picture->img->basename . '.' . $picture->img->extension);
                        $picture->img = 'uploads/' . $picture->img->basename . '.' . $picture->img->extension;
                        $picture->adrress_id = $address_id;
                        $picture->save();
                    } else {
                        $picturemodel->img = 'none';
                        return $this->redirect('addresses?package_id='.$package_id);
                    }
                }

                return $this->redirect('addresses?package_id='.$package_id);

            }






            return $this->render('addresses', compact('addresses', 'model', 'buttonname', 'package_id', 'items_region', 'picturemodel', 'address_id'));
        } else {
            return $this->goHome();
        }
    }*/

    public function actionRemovepackage($product_id, $idremove)
    {
        if (Yii::$app->user->identity->role_id == 1) {


            $onepackage = Packages::findOne($idremove);
            /*$addresses
            for ($i = 0; $i < count($addresses); $i++) {
                $addresses[$i]->delete();
            }*/
            $onepackage->delete();

            return $this->redirect('packages?product_id='.$product_id);
        } else {
            return $this->goHome();
        }
    }


    public function actionRegions($city_id , $idedit = null)
    {

        if (Yii::$app->user->identity->role_id == 1) {


            $buttonname = 'Добавить';
            $regions = Regions::find()->where('city_id='.$city_id)->all();

            if ($idedit) {
                $buttonname = 'Редактировать';
                $model = Regions::findOne($idedit);
                if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                    return $this->redirect('regions?city_id='.$city_id);
                }
                return $this->render('regions', compact('regions', 'model', 'buttonname', 'city_id'));
            }
            $model = new Regions();

            if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                return $this->redirect('regions?city_id='.$city_id);
            }

            return $this->render('regions', compact('regions', 'model', 'buttonname', 'city_id'));
        } else {
            return $this->goHome();
        }
    }


    public function actionRemoveregion($city_id, $idremove)
    {
        if (Yii::$app->user->identity->role_id == 1) {


            $oneregion = Regions::findOne($idremove);
            $oneregion->delete();

            return $this->redirect('regions?city_id='.$city_id);
        } else {
            return $this->goHome();
        }
    }
    public function actionRemoveaddress($package_id, $idremove)
    {
        if (Yii::$app->user->identity->role_id == 1) {


            $oneaddress = Addresses::findOne($idremove);
            $oneaddress->delete();

            return $this->redirect('addresses?package_id='.$package_id);
        } else {
            return $this->goHome();
        }
    }



    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    //API для бота

    public function actionGetclients()
    {
        $clients = Clients::find()->all();
        $json = [];

        foreach ($clients as $client) {
            array_push($json, [$client->id, $client->username, $client->password, $client->tg_id, $client->xmr_address, $client->xmr_id,$client->balance, $client->real_balance, $client->remember_token, $client->created_at, $client->updated_at]);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    public function actionXmrp()
    {
        $adjustment = Adjustment::find()->one();
        $json = [];



        return $adjustment->adjustment;
    }

    public function actionCreserved($tg)
    {
        $xmr_address = Clients::find()->where(['tg_id' => $tg])->one();

        return $xmr_address->xmr_address;
    }

    public function actionGetimages($address_id)
    {
        $images = ImgsToAddresses::find()->where(['address_id' => $address_id])->all();
        $json = [];

        foreach ($images as $image) {
            array_push($json, [$image->img]);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    public function actionGetaddrbal($id)
    {
        $price = Packages::find()->where(['id' => $id])->one();
        $json = [];


        return $price->price;
    }

    public function actionGetcities()
    {
        $cities = Cities::find()->all();
        $json = [];

        foreach ($cities as $city) {
            array_push($json, [$city->id, $city->name, $city->created_at, $city->updated_at]);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    public function actionGetproducts($city_id)
    {
        $products = Products::find()->where(['city_id' => $city_id])->all();
        $json = [];

        foreach ($products as $product) {
            array_push($json, [$product->id, $product->name,$product->count, $product->city_id, $product->ed_id, $product->created_at, $product->updated_at]);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    public function actionGetpackages($product_id)
    {
        $packages = Packages::find()->where(['product_id' => $product_id])->all();
        $json = [];

        foreach ($packages as $package) {
            array_push($json, [$package->id, $package->size, $package->price, $package->salary, $package->product_id, $package->created_at, $package->updated_at]);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    public function actionGeted($id)
    {
        $ed = Products::find()->where(['id' => $id])->one();


        return $ed->ed->type;
    }

    public function actionGetproduct($id)
    {
        $product = Products::find()->where(['id' => $id])->one();

        return json_encode([$product->id, $product->name,$product->count, $product->city_id, $product->ed_id, $product->created_at, $product->updated_at], JSON_UNESCAPED_UNICODE);
    }

    public function actionGetaddresses($package_id)
    {
        $addresses = Addresses::find()->where(['package_id' => $package_id])->all();
        $json = [];

        foreach ($addresses as $address) {
            array_push($json, [$address->id, $address->desc, $address->status, $address->package_id, $address->region_id, $address->leg_id, $address->tg_id, $address->created_at, $address->updated_at]);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }


    /*public function actionGetaddressesr($package_id)
    {
        $addresses = Addresses::find()->where(['package_id' => $package_id, 'status' => 'Доступен'])->all();
        $json = [];

        $r_id = [];
        foreach ($addresses as $address) {
            if (count($r_id) > 0) {
                $bool = false;
                foreach ($r_id as $id) {
                    if ($address->region_id == $id) {
                        $bool = false;
                    } else {
                        $bool = true;
                    }
                }
                if ($bool) {
                    array_push($r_id, $address->region_id);
                    array_push($json, [$address->id, $address->region_id]);
                }
            }
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }*/





    public function actionGetaddressesr($package_id)
    {
        $addresses = Addresses::find()->where(['package_id' => $package_id, 'status' => 'Доступен'])->groupBy('region_id')->all();
        $json = [];


        foreach ($addresses as $address) {
            array_push($json, [$address->id, $address->region_id]);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    public function actionGetregion($id)
    {
        $region = Regions::find()->where(['id' => $id])->one();




        return json_encode([$region->id, $region->name, $region->city_id, $region->created_at, $region->updated_at], JSON_UNESCAPED_UNICODE);
    }

    public function actionGetstatus($id)
    {
        $status = Addresses::find()->where(['id' => $id])->one();


        return $status->status;
    }

    public function actionSreserved($tg_id, $id, $price)
    {
        $model = Addresses::findOne($id);

        $model->reservation_price = $price;
        $model->tg_id = $tg_id;
        $model->status = 'Зарезервирован';
        $model->save();
    }

    public function actionGetstatusid($tg_id)
    {
        $id = Addresses::find()->where(['tg_id' => $tg_id])->one();

        return $id->id;
    }

    public function actionCreservation($id)
    {
        $model = Addresses::findOne($id);

        $model->tg_id = 0;
        $model->status = 'Доступен';
        $model->save();
    }

    public function actionGetprice($id)
    {
        $package_id = Addresses::find()->where(['id' => $id])->one();


        return $package_id->package->price;
    }

    public function actionGetuserbal($tg_id)
    {
        $userbal = Clients::find()->where(['tg_id' => $tg_id])->one();


        return $userbal->balance;
    }

    public function actionGetuseraddr($tg_id)
    {
        $address = Addresses::find()->where(['tg_id' => $tg_id])->one();

        return $address->package->price;
    }

    public function actionCommitted($tg_id)
    {
        $address = Addresses::find()->where(['tg_id' => $tg_id])->one();


        return json_encode([$address->id, $address->desc, $address->status, $address->package_id, $address->region_id, $address->leg_id, $address->tg_id, $address->reservation_price, $address->created_at, $address->updated_at], JSON_UNESCAPED_UNICODE);
    }

    public function actionSold($tg_id, $bal)
    {
        $address = Addresses::find()->where(['tg_id' => $tg_id])->one();
        $address->status = 'Доставлен';
        $address->updated_at = date('Y-m-d');
        $address->tg_id = 0;
        $address->save();

        $client = Clients::find()->where(['tg_id' => $tg_id])->one();
        $client->balance = $bal;
        $client->save();
    }

    public function actionPassupdate($tg_id, $name)
    {

        $client = Clients::find()->where(['username' => $name])->one();
        $client->tg_id = $tg_id;
        $client->save();
    }

    public function actionCheck($tg_id)
    {
        $client = Clients::find()->where(['tg_id' => $tg_id])->one();

        return json_encode([$client->id, $client->username, $client->password, $client->tg_id, $client->xmr_address, $client->xmr_id,$client->balance, $client->real_balance, $client->remember_token, $client->created_at, $client->updated_at], JSON_UNESCAPED_UNICODE);
    }

    public function actionCreate($username, $password, $tg_id, $xmr_address, $xmr_id, $balance, $real_balance)
    {
        $client = new Clients();
        $client->username = $username;
        $client->password = $password;
        $client->tg_id = $tg_id;
        $client->xmr_address = $xmr_address;
        $client->xmr_id = $xmr_id;
        $client->balance = $balance;
        $client->real_balance = $real_balance;
        $client->save();
    }

    public function actionRbalupdate($xmr_id, $rbal)
    {

        $client = Clients::find()->where(['xmr_id' => $xmr_id])->one();
        $client->real_balance = $rbal;
        $client->save();
    }

    public function actionBalupdate($xmr_id, $bal)
    {

        $client = Clients::find()->where(['xmr_id' => $xmr_id])->one();
        $client->balance = $bal;
        $client->save();
    }


    public function actionExit($tg_id)
    {

        $client = Clients::find()->where(['tg_id' => $tg_id])->one();
        $client->tg_id = 0;
        $client->save();
    }

    public function actionSalesapi($date, $leg_id = 0)
    {

        if ($leg_id) {
            $addresses = Addresses::find()->where(['updated_at' => $date, 'leg_id' => $leg_id])->all();
        } else {
            $addresses = Addresses::find()->where(['updated_at' => $date])->all();
        }

        $json = [];

        foreach ($addresses as $address) {
            array_push($json, ['id' => $address->id, 'namei' => $address->package->product->name, 'price' => $address->package->price, 'desc' => $address->desc, 'status' => $address->status, 'name' => $address->region->city->name, 'username' => $address->leg->username, 'package_id' => $address->package_id, 'region_id' => $address->region_id, 'leg_id' => $address->leg_id, 'tg_id' => $address->tg_id, 'created_at' => $address->created_at, 'updated_at' => $address->updated_at]);
        }

        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    public function actionSales()
    {
        return $this->render('sales');
    }

    public function actionSalesleg()
    {
        $leg_id = Yii::$app->user->identity->id;

        return $this->render('salesleg', compact('leg_id'));
    }

    public function actionImages($address_id)
    {

        $images = ImgsToAddresses::find()->where(['address_id'=>$address_id])->all();

        return $this->render('images', compact('images'));

    }

    public function actionStats()
    {
        $mda = (int)date('d')-7;

        if (Yii::$app->user->identity->role_id != 1) {
            $today = Addresses::find()->where(['updated_at' => date('Y-m-d'), 'status' => 'Доставлен', 'leg_id' => Yii::$app->user->identity->id])->all();
            $month = Addresses::findBySql('SELECT * FROM addresses WHERE `leg_id` = '.Yii::$app->user->identity->id.' AND MONTH(`updated_at`) = '.date('m').' AND YEAR(`updated_at`) = '.date('Y').' AND `status` = "Доставлен"')->all();
            $seven = Addresses::findBySql('SELECT * FROM addresses WHERE `leg_id` = '.Yii::$app->user->identity->id.' AND DAY(`updated_at`) BETWEEN '.$mda.' AND '.date('d').' AND `status` = "Доставлен"')->all();
        } else {
            $today = Addresses::find()->where(['updated_at' => date('Y-m-d'), 'status' => 'Доставлен'])->all();
            $month = Addresses::findBySql('SELECT * FROM addresses WHERE MONTH(`updated_at`) = '.date('m').' AND YEAR(`updated_at`) = '.date('Y').' AND `status` = "Доставлен"')->all();
            $seven = Addresses::findBySql('SELECT * FROM addresses WHERE DAY(`updated_at`) BETWEEN '.$mda.' AND '.date('d').' AND `status` = "Доставлен"')->all();
        }


        $todayP = 0;
        $countT = 0;
        foreach ($today as $t) {
            $todayP += $t->package->price;
            $countT++;
        }
        $monthP = 0;
        $countM = 0;
        foreach ($month as $m) {
            $monthP += $m->package->price;
            $countM++;
        }
        $sevenP = 0;
        $countS = 0;
        foreach ($seven as $s) {
            $sevenP += $s->package->price;
            $countS++;
        }
        $res = ['today' => ['price' => $todayP, 'count' => $countT], 'month' => ['price' => $monthP, 'count' => $countM], 'seven' => ['price' => $sevenP, 'count' => $countS]];
        $adj = Adjustment::find()->one();

        if ($adj->load(Yii::$app->request->post())) {
            $adj->save();
        }


        return $this->render('stats', compact('res', 'adj'));
    }

    public function actionGetadj() {
        return Adjustment::find()->one()->adjustment;
    }

    public function actionGetconfig()
    {
        $config = TgConfig::find()->one();
        return json_encode(['token' => $config->bot_token, 'addr' => $config->xmr_address],JSON_UNESCAPED_UNICODE);
    }

    public function actionConfig()
    {
        if (Yii::$app->user->identity->role_id != 1)
        {
            $this->goHome();
        }
        $config = TgConfig::find()->one();
        if($model = $config) {

            if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                return $this->redirect('config');
            }
        }

        return $this->render('config', compact('model', 'config'));
    }

    public function actionTexts()
    {
        if (Yii::$app->user->identity->role_id != 1)
        {
            $this->goHome();
        }
        $texts = Texts::find()->one();
        if($model = $config) {

            if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->identity->role_id == 1) {
                return $this->redirect('config');
            }
        }

        return $this->render('config', compact('model', 'config'));
    }

}
