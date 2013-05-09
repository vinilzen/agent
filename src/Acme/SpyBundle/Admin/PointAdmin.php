<?php
namespace Acme\SpyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

class PointAdmin extends Admin
{
    /**
     * Конфигурация отображения записи
     *
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('id', null, array('label' => 'Идентификатор'))
                ->add('title', null, array('label' => 'Название'))
                ->add('description', null, array('label' => 'Подсказка по часам работы точки'))
                ->add('longitude', null, array('label' => 'Координаты места (долгота)'))
                ->add('latitude', null, array('label' => 'Координаты места (широта)'))
                ->add('franchise', null, array('label' => 'Сеть торговых точек'));
    }

    /**
     * Конфигурация формы редактирования записи
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('title', null, array('label' => 'Название'))
                ->add('description', null, array('label' => 'Подсказка по часам работы точки'))
                ->add('longitude', 'text', array('label' => 'Координаты места (долгота)'))              
                ->add('latitude', 'text', array('label' => 'Координаты места (широта)'))              
                ->add('franchise', null, array('label' => 'Сеть торговых точек'))
                ->setHelps(array(
                                'title' => 'Название торговой точки',
                                'logo' => 'Путь к картинке логотипу',
                                'description' => 'Подсказка по часам работы точки',
                                'longitude' => 'Координаты места (долгота) "43.1341313"',
                                'latitude' => 'Координаты места (широта) "56.245245"',
                                'franchise' => 'К какой сети относится' 
                           ));

    }

    /**
     * Конфигурация списка записей
     *
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('id')
                ->addIdentifier('title', null, array('label' => 'Название'))
                ->add('description', null, array('label' => 'Подсказка по часам работы точки'))
                ->add('longitude', null, array('label' => 'Координаты места (долгота)'))
                ->add('latitude', null, array('label' => 'Координаты места (широта)'))
                ->add('franchise', null, array('label' => 'Сеть торговых точек'));
    }

    /**
     * Поля, по которым производится поиск в списке записей
     *
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('title', null, array('label' => 'Название'));
    }

    /**
     * Конфигурация левого меню при отображении и редатировании записи
     *
     * @param \Knp\Menu\ItemInterface $menu
     * @param $action
     * @param null|\Sonata\AdminBundle\Admin\AdminInterface $childAdmin
     * @return void
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if ($action == 'edit' || $action == 'show')
        $menu->addChild(
            $action == 'edit' ? 'Просмотр точки' : 'Редактирование точки',
            array('uri' => $this->generateUrl(
                $action == 'edit' ? 'show' : 'edit', array('id' => $this->getRequest()->get('id'))))
        );
    }
}