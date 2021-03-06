<?php
/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
namespace PrestaShopBundle\Form\Admin\ShopParameters\General;

use Symfony\Component\Form\FormFactoryInterface;
use PrestaShop\PrestaShop\Core\Form\AbstractFormHandler;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

/**
 * This class manages the data manipulated using forms
 * in "Configure > Advanced Parameters > Performance" page.
 */
final class MaintenanceFormHandler extends AbstractFormHandler
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormDataProviderInterface
     */
    private $formDataProvider;

    public function __construct(
        FormFactoryInterface $formFactory,
        FormDataProviderInterface $formDataProvider
    )
    {
        $this->formFactory = $formFactory;
        $this->formDataProvider = $formDataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        $formBuilder = $this->formFactory->createBuilder()
            ->add('general', MaintenanceType::class)
            ->setData($this->formDataProvider->getData())
        ;

        $this->hookDispatcher->dispatchForParameters('displayMaintenancePageForm', ['form_builder' => &$formBuilder]);

        return $formBuilder->setData($formBuilder->getData())->getForm();
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data)
    {
        $errors = $this->formDataProvider->setData($data);

        $this->hookDispatcher->dispatchForParameters('actionMaintenancePageFormSave', ['errors' => &$errors, 'form_data' => &$data]);

        return $errors;
    }
}
