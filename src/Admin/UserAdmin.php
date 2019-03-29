<?php

namespace App\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('roles')
            ->add('enabled')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('lastLogin')
            ->add('csvRoles',null,array('label'=>'Roles'))
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $rolesHierarchy = $this->getConfigurationPool()->getContainer()->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($rolesHierarchy);
        $roles = array_combine($roles,$roles);

        $role = null;

        $subject = $this->getSubject();
        if($subject->getId())
        {
            $role = $subject->getRoles()[0];
        }

        $label = 'Password'; $placeholder = "Please provide password";
        $constraint = array(new NotBlank(array('message' => 'The Password field is required')));
        if($subject->getId()) {
            $label       = 'New Password';
            $placeholder = 'Empty if password is not to be changed';
            $constraint = array();
        }

        $formMapper
            ->add('username')
            ->add('email')

            ->add('newPass', PasswordType::class, array(
                'label'    => $label,
                'attr'     => array('placeholder' => $placeholder),
                'required' => false,
                'constraints' => $constraint
            ))
            ->add('role', ChoiceType::class, array(
                'required' => false,
                'choices'  => $roles,
                'multiple' => false,
                'data'     => $role,
                'constraints' => array(new NotBlank(array('message' => 'The Role field is required')))
            ))

            ->add('enabled')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('lastLogin')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
        ;
    }

    public function prePersist($object)
    {
        $role = $object->getRole();
        $object->setRoles([$role]);
        $object->setUsername($object->getEmail());


        parent::prePersist($object);
        $this->updateUser($object);
    }

    public function preUpdate($object)
    {
        $role = $object->getRole();
        $object->setRoles([$role]);
        $object->setUsername($object->getEmail());

        parent::preUpdate($object);
        $this->updateUser($object);
    }

    public function updateUser(User $user)
    {
        if ($user->getNewPass())
        {
            $user->setPlainPassword($user->getNewPass());
        }

        $um = $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager');
        $um->updateUser($user, false);
    }
}
