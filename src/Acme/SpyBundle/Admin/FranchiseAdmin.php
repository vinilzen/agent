<?php
namespace Acme\SpyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

class FranchiseAdmin extends Admin
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
                ->add('logo', 'image', array('label' => 'Лого'))
                ->add('brand', null, array('label' => 'Бренд'))
                ->add('industry', null, array('label' => 'Индустрия задания (horeca, cpg, retail)'));
    }

    /**
     * Конфигурация формы редактирования записи
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('logo', 'file', array('label' => 'Лого'))
                ->add('brand', null, array('label' => 'Бренд'))
                ->add('industry', null, array('label' => 'Индустрия'))

        //by_reference используется для того чтобы при трансформации данных запроса в объект сущности
        //которую выполняет Symfony Form Framework, использовался setter сущности News::setNewsLinks
                
        /*
                ->add('newsLinks', 'sonata_type_collection',
                      array('label' => 'Ссылки', 'by_reference' => false),
                      array(
                           'edit' => 'inline',
                           //В сущности NewsLink есть поле pos, отражающее положение ссылки в списке
                          //указание опции sortable позволяет менять положение ссылок в списке перетаскиваением
                           'sortable' => 'pos',
                           'inline' => 'table',
                      ))
                ->add('newsCategory', null, array('label' => 'Категория'))*/
                ->setHelps(array(
                                'logo' => 'Лого сети',
                                'brand' => 'Бренд торговых точек',
                                'industry' => 'Индустрия задания (horeca, cpg, retail)'
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
                ->addIdentifier('brand', null, array('label' => 'Бренд'))
                ->add('logo', 'image', array('label' => 'Лого'))
                ->add('industry', null, array('label' => 'Индустрия'));
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
                ->add('brand', null, array('label' => 'Бренд'))
                ->add('industry', null, array('label' => 'Индустрия'));
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
            $action == 'edit' ? 'Просмотр сети' : 'Редактирование сети',
            array('uri' => $this->generateUrl(
                $action == 'edit' ? 'show' : 'edit', array('id' => $this->getRequest()->get('id'))))
        );
    }
}