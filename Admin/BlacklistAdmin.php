<?php

namespace AntoineLemaire\BlacklistBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BlacklistAdmin extends Admin
{

    /**
     * {@inheritDoc}
     */
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_by' => 'createdAt',
        '_sort_order' => 'DESC'
    );
    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_general')
            ->add('email')
            ->add('createdAt')
            ->end()
        ;
    }
    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('createdAt')
        ;
    }
    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
        ;
    }

}