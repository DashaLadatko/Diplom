<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Filenmkd;

/**
 * FilenmkdSearch represents the model behind the search form about `common\models\Filenmkd`.
 */
class FilenmkdSearch extends Filenmkd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'discipline_id', 'component_nmkd_id', 'user_id', 'protocol_chair', 'protocol_fuculty', 'protocol_university', 'total', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'signature', 'comment'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Filenmkd::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'discipline_id' => $this->discipline_id,
            'component_nmkd_id' => $this->component_nmkd_id,
            'user_id' => $this->user_id,
            'protocol_chair' => $this->protocol_chair,
            'protocol_fuculty' => $this->protocol_fuculty,
            'protocol_university' => $this->protocol_university,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'signature', $this->signature])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
