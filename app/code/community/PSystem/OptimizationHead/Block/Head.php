<?php
/**
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * Pascal Head combine
 * 
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
class PSystem_OptimizationHead_Block_Head extends PSystem_OptimizationHead_Block_Head_Abstract {
/**
 * Get HEAD HTML with CSS/JS/RSS definitions
 * (actually it also renders other elements, TODO: fix it up or rename this method)
 *
 * @return string
 */
	public function getCssJsHtml() {
		if (Mage::getStoreConfig('psoptimizationhead/extension/disable')) {
			return parent::getCssJsHtml();
		}
		
		// separate items by types
		$lines  = array();
		foreach ($this->_data['items'] as $item) {
			if (!is_null($item['cond']) && !$this->getData($item['cond']) || !isset($item['name'])) {
				continue;
			}
			$if     = !empty($item['if']) ? $item['if'] : '';
			$params = !empty($item['params']) ? $item['params'] : '';
			switch ($item['type']) {
				case 'js':        // js/*.js
				case 'skin_js':   // skin/*/*.js
				case 'js_css':    // js/*.css
				case 'skin_css':  // skin/*/*.css
					$lines[$if][$item['type']][$params][$item['name']] = $item['name'];
					break;
				default:
					$this->_separateOtherHtmlHeadElements($lines, $if, $item['type'], $params, $item['name'], $item);
					break;
			}
		}

		//prepare HTML
		$shouldMergeJs = Mage::getStoreConfigFlag('dev/js/merge_files');
		$shouldMergeCss = Mage::getStoreConfigFlag('dev/css/merge_css_files');
		$html   = '';
		
		$designPackage = Mage::getDesign();
		foreach ($lines as $cond => $types) {
			if (!is_array($types)) continue;
			foreach ($types as $type => $params) {
				if (!is_array($params)) continue;
				foreach ($params as $param => $items) {
					if (!is_array($items)) continue;
					foreach ($items as $itemKey => $itemVal) {
						if ($type == 'js') {
							if (!isset($lines[$cond][$type][$param]['combine']))
								$lines[$cond][$type][$param]['combine'] = '';
							
							if ($lines[$cond][$type][$param]['combine']) {
								$lines[$cond][$type][$param]['combine'].= ','.$itemVal;
							} else {
								$lines[$cond][$type][$param]['combine'].= 'file='.$itemVal;
							}
							
							unset($lines[$cond][$type][$param][$itemKey]);
						} elseif ($type == 'skin_js') {
							if (!isset($lines[$cond][$type][$param]['combineskin']))
								$lines[$cond][$type][$param]['combineskin'] = '';
							
							if ($lines[$cond][$type][$param]['combineskin']) {
								$lines[$cond][$type][$param]['combineskin'].= ','.$this->getSkinFile($designPackage,$itemVal);
							} else {
								$lines[$cond][$type][$param]['combineskin'].= 'file='.$this->getSkinFile($designPackage,$itemVal);
							}
							unset($lines[$cond][$type][$param][$itemKey]);
						} elseif ($type == 'js_css') {
							if (!isset($lines[$cond][$type][$param]['combinecss']))
								$lines[$cond][$type][$param]['combinecss'] = '';
							
							if ($lines[$cond][$type][$param]['combinecss']) {
								$lines[$cond][$type][$param]['combinecss'].= ','.$itemVal;
							} else {
								$lines[$cond][$type][$param]['combinecss'].= 'file='.$itemVal;
							}
							unset($lines[$cond][$type][$param][$itemKey]);
						} elseif ($type == 'skin_css') {
							if (!isset($lines[$cond][$type][$param]['combineskincss']))
								$lines[$cond][$type][$param]['combineskincss'] = '';
							
							if ($lines[$cond][$type][$param]['combineskincss']) {
								$lines[$cond][$type][$param]['combineskincss'].= ','.$this->getSkinFile($designPackage,$itemVal);
							} else {
								$lines[$cond][$type][$param]['combineskincss'].= 'file='.$this->getSkinFile($designPackage,$itemVal);
							}
							unset($lines[$cond][$type][$param][$itemKey]);
						}
					}
				}
			}
		}
		
		foreach ($lines as $if => $items) {
			if (empty($items)) {
				continue;
			}
			if (!empty($if)) {
				$html .= '<!--[if '.$if.']>'."\n";
			}
			
			// static and skin css
			$html .= $this->_prepareStaticAndSkinElements('<link rel="stylesheet" type="text/css" href="%s"%s />' . "\n",
				empty($items['js_css']) ? array() : $items['js_css'],
				empty($items['skin_css']) ? array() : $items['skin_css'],
				$shouldMergeCss ? array(Mage::getDesign(), 'getMergedCssUrl') : null
			);
			
			// static and skin javascripts
			$html .= $this->_prepareStaticAndSkinElements('<script type="text/javascript" src="%s"%s></script>' . "\n",
				empty($items['js']) ? array() : $items['js'],
				empty($items['skin_js']) ? array() : $items['skin_js'],
				$shouldMergeJs ? array(Mage::getDesign(), 'getMergedJsUrl') : null
			);
			
			// other stuff
			if (!empty($items['other'])) {
				$html .= $this->_prepareOtherHtmlHeadElements($items['other']) . "\n";
			}
			
			if (!empty($if)) {
				$html .= '<![endif]-->'."\n";
			}
		}
		return $html;
	}

/**
 * Merge static and skin files of the same format into 1 set of HEAD directives or even into 1 directive
 *
 * Will attempt to merge into 1 directive, if merging callback is provided. In this case it will generate
 * filenames, rather than render urls.
 * The merger callback is responsible for checking whether files exist, merging them and giving result URL
 *
 * @param string $format - HTML element format for sprintf('<element src="%s"%s />', $src, $params)
 * @param array $staticItems - array of relative names of static items to be grabbed from js/ folder
 * @param array $skinItems - array of relative names of skin items to be found in skins according to design config
 * @param callback $mergeCallback
 * @return string
 */
	protected function &_prepareStaticAndSkinElements($format, array $staticItems, array $skinItems, $mergeCallback = null) {
		$designPackage = Mage::getDesign();
		$baseJsUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS);
		
		$additionalParams = '';
		if ($timeRefreshing = intval(Mage::getStoreConfig('psoptimizationhead/compress/refresh'))) {
			$additionalParams.= 'refresh='.$timeRefreshing.'&amp;';
		}
		if (Mage::getStoreConfig('psoptimizationhead/compress/nocache')) {
			$additionalParams.= 'nocache=1&amp;';
		}
		if (Mage::getStoreConfig('psoptimizationhead/compress/gzipoff')) {
			$additionalParams.= 'gzipoff=1&amp;';
		}
		if (Mage::getStoreConfig('psoptimizationhead/compress/minifyoff')) {
			$additionalParams.= 'minoff=1&amp;';
		}
		
		
		$baseCombineUrl = $baseJsUrl.'pascalsystem/combine.php?type=js&amp;'.$additionalParams;
		$baseCombineSkinUrl = $baseJsUrl.'pascalsystem/combine.php?type=jsskin&amp;'.$additionalParams;
		$baseCombineCss = $baseJsUrl.'pascalsystem/combine.php?type=css&amp;'.$additionalParams;
		$baseCombineSkinCss = $baseJsUrl.'pascalsystem/combine.php?type=cssskin&amp;'.$additionalParams;
		$items = array();
		if ($mergeCallback && !is_callable($mergeCallback)) {
			$mergeCallback = null;
		}
		
		// get static files from the js folder, no need in lookups
		foreach ($staticItems as $params => $rows) {
			foreach ($rows as $key => $name) {
				if ($key == 'combine') {
					$items[$params][] = $baseCombineUrl.$name;
				} elseif ($key == 'combinecss') {
					$items[$params][] = $baseCombineCss.$name;
				} else {
					$items[$params][] = $mergeCallback ? Mage::getBaseDir() . DS . 'js' . DS . $name : $baseJsUrl . $name;
				}
			}
		}
		
		// lookup each file basing on current theme configuration
		foreach ($skinItems as $params => $rows) {
			foreach ($rows as $key => $name) {
				if ($key == 'combineskin') {
					$items[$params][] = $baseCombineSkinUrl.$name;
				} elseif ($key == 'combineskincss') {
					$items[$params][] = $baseCombineSkinCss.$name;
				} else {
					$items[$params][] = $mergeCallback ? $designPackage->getFilename($name, array('_type' => 'skin')):$designPackage->getSkinUrl($name, array());
				}
			}
		}
		
		$html = '';
		foreach ($items as $params => $rows) {
			// attempt to merge
			$mergedUrl = false;
			if ($mergeCallback) {
				$mergedUrl = call_user_func($mergeCallback, $rows);
			}
			// render elements
			$params = trim($params);
			$params = $params ? ' ' . $params : '';
			if ($mergedUrl) {
				$html .= sprintf($format, $mergedUrl, $params);
			} else {
				foreach ($rows as $src) {
					$html .= sprintf($format, $src, $params);
				}
			}
		}
		return $html;
	}
	
/**
 * Create skin url and cut base skin url
 * 
 * @param Mage_Core_Model_Design_Package $designPackage
 * @param string $fileName
 * @return string
 */
	protected function getSkinFile(Mage_Core_Model_Design_Package $designPackage, $fileName) {
		return str_replace(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN),'',$designPackage->getSkinUrl($fileName));
	}
}