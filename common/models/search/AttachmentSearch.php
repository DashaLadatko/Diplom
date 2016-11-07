<?php

namespace common\models\search;

use common\components\upload\configAttachment;
use common\components\upload\uploader;
use common\models\Event;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Attachment;

/**
 * AttachmentSearch represents the model behind the search form about `common\models\Attachment`.
 */
class AttachmentSearch extends Attachment
{
    public $page = 0;
    public $size = 20;
    public $sort = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'obj_id', 'created_at', 'created_by', 'updated_at', 'updated_by',  'size', 'page'], 'integer'], // 'show',
            [['name', 'real_name', 'obj_type', 'type', 'path', 'thumbnail_path', 'ext'], 'safe'],
            [['sort'], 'safe'],
            ['show', 'default', 'value' => self::SHOW_TRUE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = Attachment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->size,
                'page' => $this->page
            ]
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
            'obj_id' => $this->obj_id,
            'show' => $this->show,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'real_name', $this->real_name])
            ->andFilterWhere(['like', 'obj_type', $this->obj_type])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'thumbnail_path', $this->thumbnail_path])
            ->andFilterWhere(['like', 'ext', $this->ext]);

        return $dataProvider;
    }
}
