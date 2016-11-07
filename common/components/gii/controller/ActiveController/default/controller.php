<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */

echo "<?php\n";
?>
namespace <?= $generator->getControllerNamespace() ?>;

use Yii;
use yii\behaviors;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
    public $modelClass = 'common\models\';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            //'class' => HttpBasicAuth::className();
            //'class' => CompositeAuth::className();
            'only' => [],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [''],
            'rules' => [
                [
                    'actions' => [''],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['verbFilter'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                '' => ['']
            ],
        ];

    return $behaviors;
    }
<?php foreach ($generator->getActionIDs() as $action): ?>
    public function action<?= Inflector::id2camel($action) ?>()
    {
        return $this->render('<?= $action ?>');
    }

<?php endforeach; ?>
}
