<?php
namespace Acme\SpyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

class QuestionAdmin extends Admin
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
                ->add('question', null, array('label' => 'Вопрос'))
                ->add('limitAnswer', null, array('label' => 'Количество разрещенных ответов'))
                ->add('answers', null, array('label' => 'Доступные ответы (опционально)'))
                ->add('mission', null, array('label' => 'Задание'))
                ->add('questionType', null, array('label' => 'Тип вопроса'));
    }


    /**
     * Конфигурация формы редактирования записи
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('question', null, array('label' => 'Вопрос'))
                ->add('limitAnswer', null, array('label' => 'Количество разрещенных ответов'))
                ->add('answers', null, array('label' => 'Доступные ответы (опционально)'))
                ->add('mission', null, array('label' => 'Задание'))
                ->add('questionType', null, array('label' => 'Тип вопроса'));

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
                ->addIdentifier('question', null, array('label' => 'Время выполнения'))
                ->addIdentifier('mission', null, array('label' => 'Задание'))
                ->add('questionType', null, array('label' => 'Тип вопроса'))
                ->add('limitAnswer', null, array('label' => 'Количество разрещенных ответов'))
                ->add('answers', null, array('label' => 'Доступные ответы (опционально)'));
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
                ->add('mission', null, array('label' => 'Задание'));
    }
}