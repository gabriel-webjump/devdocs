<?php

namespace Gene\BlueFoot\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class SavePageBuilder
 *
 * @package Gene\BlueFoot\Observer
 *
 * @author Dave Macaulay <dave@gene.co.uk>
 */
class SavePageBuilder implements ObserverInterface
{
    /**
     * @var \Gene\BlueFoot\Model\Stage\SaveFactory
     */
    protected $_saveFactory;

    /**
     * SavePageBuilder constructor.
     *
     * @param \Gene\BlueFoot\Model\Stage\SaveFactory $saveFactory
     */
    public function __construct(
        \Gene\BlueFoot\Model\Stage\SaveFactory $saveFactory
    ) {
        $this->_saveFactory = $saveFactory;
    }

    /**
     * Save the page builder data
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var $controllerAction \Magento\Cms\Controller\Adminhtml\Page\Index\Interceptor */
        $controllerAction = $observer->getEvent()->getControllerAction();

        // Watch for any structures
        if ($structures = $controllerAction->getRequest()->getParam('gene-bluefoot')) {
            $this->_saveFactory->create()->saveStructures($structures);
        }
    }
}
