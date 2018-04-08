<?php

namespace AntoineLemaire\BlacklistBundle\Admin;

use AntoineLemaire\BlacklistBundle\Model\BlacklistType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class BlacklistAdmin.
 */
class BlacklistAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $datagridValues = [
        '_page'       => 1,
        '_sort_by'    => 'createdAt',
        '_sort_order' => 'DESC',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_general')
            ->add('type', ChoiceType::class, [
                'choices'  => BlacklistType::getAll(),
            ])
            ->add('value')
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type')
            ->add('value')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    //list of fields that could be used to thriller
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('type')
            ->add('value')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => [],
                ],
            ]
            );
    }
}
