<?php

namespace e1\Controllers;

use e1\traits\Restriction;
use Silex;
use e1\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class coreCRUD implements ControllerProviderInterface {

    protected $modelName;
    protected $layoutTemplate;
    protected $listTemplate;
    protected $itemTemplate;
    protected $secure;

    public function __construct($layoutTemplate, $listTemplate = null, $itemTemplate = null) {
        $this->layoutTemplate = $layoutTemplate;

        $tplDir = substr(strrchr(get_called_class(), "\\"), 1);
        $this->listTemplate = $listTemplate ?: 'widget/' . $tplDir . '/list';
        $this->itemTemplate = $itemTemplate ?: 'widget/' . $tplDir . '/item';
    }

    public function connect(Silex\Application $app) {
        /* @var $controllers \Silex\ControllerCollection */
        $controllers = $app['controllers_factory'];
        if ($this->secure) {
            $controllers->secure($this->secure['roles'], $this->secure['redirect_url']);
        }
        $controllers->get('/', [$this, 'getList'])->bind($this->modelName . '.list');
        $controllers->get('/{id}', [$this, 'getById'])->assert('id', '[^/]+')->bind($this->modelName . '.get');
        $controllers->delete('/{id}', [$this, 'delById'])->assert('id', '.+')->bind($this->modelName . '.del');
        $controllers->post('/', [$this, 'upsertById'])->bind($this->modelName . '.upsert');

        return $controllers;
    }

    public function secure($roles, $redirect_url = null) {
        $this->secure['roles'] = $roles;
        $this->secure['redirect_url'] = $redirect_url;
    }

    public function getList(Application $app, Request $request) {
        //add pager
        $model = $app->model($this->modelName);
        $data = $model->get()->toArray();

        return $app->render($this->listTemplate, ['data' => $data, 'request', $request]);
    }

    public function getById($id, Application $app, Request $request) {
        $model = $app->model($this->modelName);
        $card = $model->find($id);
        $data = isset($card->_id) ? $card->toArray() : [];

        return $app->render($this->itemTemplate, ['form' => $data]);
    }

    public function delById($id, Application $app, Request $request) {
        $app->model($this->modelName)->destroy($id);

        return $app->redirect($app->url($this->modelName . '.list'));
    }

    public function upsertById(Application $app, Request $request) {
        $form = $request->get('form');

        if (!is_array($form)) {
            return $app->redirect($app->url($this->modelName . '.list'));
        }

        $errors = $this->getErrors($form);
        if (!empty($errors)) {
            $form['errors'] = $errors;

            return $app->render($this->itemTemplate, ['form' => $form]);
        }

        $model = $app->model($this->modelName);
        $id = isset($form['_id']) ? $form['_id'] : null;
        unset($form['_id']);

        if ($id) {
            $model = $model->find($id);

            if (in_array(Restriction::class, class_uses($model), false)) {
                $model->_app = $app; // Г
            }

            $model->update($form, ['upsert' => true]);
//            $model->where('_id', '=', $id)->update($form, ['upsert' => true]);
        } else {
            $model->fill($form)->save();
        }

        return $app->redirect($app->url($this->modelName . '.list'));
    }

    protected function getErrors(array $form) {
        return [];
    }
}
