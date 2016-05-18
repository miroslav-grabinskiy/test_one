<?php

namespace backend\controllers;

use Yii;

use common\models\Address;
use common\models\Rgb;
use common\models\GoogleAPI;

use backend\models\SearchAddress;
use backend\models\ImportForm;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use yii\filters\VerbFilter;

/**
 * AddressController implements the CRUD actions for Address model.
 */
class AddressController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Address models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchAddress();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Address model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('create', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Address model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $address = new Address();
        $rgb = new Rgb();

        if ($rgb->load(Yii::$app->request->post()) && $rgb->save()) {
            $address->rgb_id = $rgb->id;
            $address->created_at = date('Y-m-d H:i:s');
            if ($address->load(Yii::$app->request->post()) && $address->save()) {
                return $this->redirect(['view', 'id' => $address->id]);
            }
        } else {
            return $this->render('create', [
                'address' => $address,
                'rgb'     => $rgb,
            ]);
        }
    }

    /**
     * Exporting date to csv file from address, rgb columns
     * @return void
     * */
    public function actionExport()
    {
        $filename = 'Data-'.Date('YmdGis').'-addresses.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=".$filename);
        echo Address::createCSV();
    }

    /**
     * Importing date from csv file to address, rgb columns
     * @return mixed
     * */
    public function actionImport()
    {
        $dir = Yii::getAlias('@app/web/uploads');

        $model = new ImportForm();

        if($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model,'file');

            if ($model->validate() && $model->file) {
                $fileFullPath = $dir . '/' .md5(date('Y-m-d H:i:s')). '.' . $model->file->extension;
                $upload = $model->file->saveAs($fileFullPath);

                if ($upload) {
                    $csv_file = $fileFullPath;
                    $fileCsv = file($csv_file);//TODO if file has more values than two columns

                    foreach ($fileCsv as $data) {
                        $rgb = new Rgb();
                        $address = new Address();
                        $api = new GoogleAPI();

                        $row = $model->explodeCSV($data);//TODO if false

                        $rgb->attributes = $row['rgb'];

                        if ($rgb->save()) {
                            $address->rgb_id = $rgb->id;
                            $address->name = $row['address'];
                            $address->created_at = date('Y-m-d H:i:s');
                            $address->location = $api->getGeoCodes($row['address']);
                            $address->save();
                        }

                    }

                }
                unlink($fileFullPath);
                return $this->redirect(['/address/index']);
            }

        } else {
            return $this->render('import', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Address model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $address = $this->findModel($id);
        $rgb = Rgb::findOne($address->rgb_id);

        if ($rgb->load(Yii::$app->request->post()) && $rgb->save()) {
            if ($address->load(Yii::$app->request->post()) && $address->save()) {
                return $this->redirect(['view', 'id' => $address->id]);
            }
        }
        else {
            return $this->render('update', [
                'address' => $address,
                'rgb'     => $rgb
            ]);
        }
    }

    /**
     * Deletes an existing Address model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Address model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Address the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
