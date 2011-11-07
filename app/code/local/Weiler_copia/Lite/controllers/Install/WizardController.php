<?php

require_once  'Mage/Install/controllers/WizardController.php';

/**
 * Installation wizard controller
 */
class Weiler_Lite_Install_WizardController extends Mage_Install_WizardController
{
    /**
     * End installation
     */
    public function endAction()
    {
        $this->_checkIfInstalled();

        $date = (string)Mage::getConfig()->getNode('global/install/date');
        if ($date !== Mage_Install_Model_Installer_Config::TMP_INSTALL_DATE_VALUE) {
            $this->_redirect('*/*');
            return;
        }

        $this->_getInstaller()->finish();

        //lite:
        if(Mage::helper('core')->isModuleEnabled('Mage_AdminNotification')) {
        	Mage_AdminNotification_Model_Survey::saveSurveyViewed(true);
        }
        //

        $this->_prepareLayout();
        $this->_initLayoutMessages('install/session');

        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('install/end', 'install.end')
        );
        $this->renderLayout();
        Mage::getSingleton('install/session')->clear();
    }

}
