<?php
namespace AirQualityInfo\Admin\Controller;

class WidgetController extends AbstractController {

    private $deviceModel;

    private $deviceHierarchyModel;

    private $widgetModel;

    public function __construct(
            \AirQualityInfo\Model\DeviceModel $deviceModel,
            \AirQualityInfo\Model\DeviceHierarchyModel $deviceHierarchyModel,
            \AirQualityInfo\Model\WidgetModel $widgetModel) {
        $this->deviceModel = $deviceModel;
        $this->deviceHierarchyModel = $deviceHierarchyModel;
        $this->widgetModel = $widgetModel;
    }

    public function index() {
        $widgets = $this->widgetModel->getWidgetsForUser($this->user['id']);
        $devices = $this->deviceModel->getDevicesForUser($this->user['id']);

        $this->render(array('view' => 'admin/views/widget/index.php'), array(
            'widgets' => $widgets,
            'devices' => $devices,
            'userForm' => $this->widgetSettingsForm()
        ));
    }

    public function updateWidgetSettings() {
        $userForm = $this->widgetSettingsForm();
        if ($userForm->isSubmitted() && $userForm->validate($_POST)) {
            $data = array(
                'sensor_widget' => $_POST['sensor_widget'],
                'all_widget' => $_POST['all_widget'],
            );
            $this->userModel->updateUser($this->user['id'], $data);
            $this->alert(__('Updated settings', 'success'));
            header('Location: '.l('widget', 'index'));
        }
    }

    private function widgetSettingsForm() {
        $userForm = new \AirQualityInfo\Lib\Form\Form("userForm");
        $userForm->addElement('sensor_widget', 'checkbox', 'Show widget on the sensor page');
        $userForm->addElement('all_widget', 'checkbox', 'Show widget on the group page');
        $userForm->setDefaultValues($this->user);
        return $userForm;
    }

    public function create() {
        $widgetForm = $this->getWidgetForm();
        if ($widgetForm->isSubmitted() && $widgetForm->validate($_POST)) {
            $widgetId = $this->widgetModel->createWidget(
                $this->user['id'],
                $_POST['title'],
                $_POST['template'],
            );
            $this->alert(__('Created a new widget', 'success'));
            header('Location: '.l('widget', 'edit', null, array('widget_id' => $widgetId)));
        } else {
            $this->render(array(
                'view' => 'admin/views/widget/domain/create.php'
            ), array(
                'widgetForm' => $widgetForm
            ));
        }
    }

    private function getWidgetForm() {
        $widgetForm = new \AirQualityInfo\Lib\Form\Form("widgetForm");
        $widgetForm->addElement('title', 'text', 'Title')->addRule('required');
        $widgetForm->addElement('template', 'select', 'Widget template')
            ->addRule('required')
            ->setOptions(array('horizontal' => __('Horizontal'), 'vertical' => __('Vertical')));
        return $widgetForm;
    }

    public function edit($widgetId) {
        $widgetForm = $this->getWidgetForm();
        $widget = $this->widgetModel->getWidgetById($this->user['id'], $widgetId);
        $widgetForm->setDefaultValues($widget);

        if ($widgetForm->isSubmitted() && $widgetForm->validate($_POST)) {
            $this->widgetModel->updateWidget(
                $this->user['id'],
                $widgetId,
                $_POST['title'],
                $_POST['template'],
            );
            $widget = $this->widgetModel->getWidgetById($this->user['id'], $widgetId);
            $this->alert(__('Updated widget', 'success'));
        }

        $widgetUri = $this->getProtocol().':'.$this->getUriPrefix()."/widget/".$widgetId;

        $this->render(array(
            'view' => 'admin/views/widget/domain/edit.php'
        ), array(
            'widgetForm' => $widgetForm,
            'widgetId' => $widgetId,
            'widgetUri' => $widgetUri,
            'widgetTemplate' => $widget['template'],
        ));
    }

    public function delete($widgetId) {
        $this->widgetModel->deleteWidget($this->user['id'], $widgetId);
        $this->alert(__('Deleted widget'));
    }

    public function showDeviceWidget($deviceId) {
        $paths = $this->deviceHierarchyModel->getDevicePaths($this->user['id'], $deviceId);
        $path = null;
        if (!empty($paths)) {
            $path = $paths[0];
        }

        $widgetUri = $this->getProtocol().':'.$this->getUriPrefix().$path.'/widget';

        $this->render(array(
            'view' => 'admin/views/widget/device/show.php'
        ), array(
            'widgetUri' => $widgetUri
        ));
    }

    private function getProtocol() {
        if (strpos(CONFIG['user_domain_suffixes'][0], '.localhost') === FALSE) {
            return 'https';
        } else {
            return 'http';
        }
    }
}
?>