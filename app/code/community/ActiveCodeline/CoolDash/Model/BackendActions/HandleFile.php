<?php

class ActiveCodeline_CoolDash_Model_BackendActions_HandleFile extends Mage_Core_Model_Config_Data
{

    /**
     * Save uploaded file before saving config value
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Image
     */
    protected function _beforeSave()
    {
        $value = $this->getValue();
        if (is_array($value) && !empty($value['delete'])) {
            $this->setValue('');
        }

        if ($_FILES['groups']['tmp_name'][$this->getGroupId()]['fields'][$this->getField()]['value']){

            $fieldConfig = $this->getFieldConfig();
            /* @var $fieldConfig Varien_Simplexml_Element */

            if (empty($fieldConfig->upload_dir)) {
                Mage::throwException(Mage::helper('catalog')->__('Base directory to upload image file is not specified'));
            }

            $uploadDir =  (string)$fieldConfig->upload_dir;

            $el = $fieldConfig->descend('upload_dir');

            /**
             * Add scope info
             */
            if (!empty($el['scope_info'])) {
                $uploadDir = $this->_appendScopeInfo($uploadDir);
            }

            /**
             * Take root from config
             */
            if (!empty($el['config'])) {
                $uploadRoot = (string)Mage::getConfig()->getNode((string)$el['config'], $this->getScope(), $this->getScopeId());
                $uploadRoot = Mage::getConfig()->substDistroServerVars($uploadRoot);
                $uploadDir = $uploadRoot . '/' . $uploadDir;
            }

            try {
                $file = array();
                $file['tmp_name'] = $_FILES['groups']['tmp_name'][$this->getGroupId()]['fields'][$this->getField()]['value'];
                $file['name'] = $_FILES['groups']['name'][$this->getGroupId()]['fields'][$this->getField()]['value'];
                $uploader = new Varien_File_Uploader($file);
                $uploader->setAllowedExtensions($this->_getAllowedExtensions());
                $uploader->setAllowRenameFiles(true);
                $uploader->save($uploadDir);
            } catch (Exception $e) {
                Mage::throwException($e->getMessage());
                return $this;
            }

            if ($filename = $uploader->getUploadedFileName()) {

                /**
                 * Add scope info
                 */
                if (!empty($el['scope_info'])) {
                    $filename = $this->_prependScopeInfo($filename);
                }

                $this->setValue($filename);
            }
        }

        return $this;
    }

    /**
     * Prepend path with scope info
     *
     * E.g. 'stores/2/path' , 'websites/3/path', 'default/path'
     *
     * @param string $path
     * @return string
     */
    protected function _prependScopeInfo($path)
    {
        $scopeInfo = $this->getScope();
        if ('default' != $this->getScope()) {
            $scopeInfo .= '/' . $this->getScopeId();
        }
        return $scopeInfo . '/' . $path;
    }

    /**
     * Add scope info to path
     *
     * E.g. 'path/stores/2' , 'path/websites/3', 'path/default'
     *
     * @param string $path
     * @return string
     */
    protected function _appendScopeInfo($path)
    {
        $path .= '/' . $this->getScope();
        if ('default' != $this->getScope()) {
            $path .= '/' . $this->getScopeId();
        }
        return $path;
    }

    protected function _getAllowedExtensions()
    {
        return array('txt', 'zip');
    }
}
