<?php

class Wee_DeveloperToolbar_Model_Observer
{
    public function removeCoreProfilerBlock($observer)
    {
        Mage::app()->getLayout()->removeOutputBlock('core_profiler');
    }
}