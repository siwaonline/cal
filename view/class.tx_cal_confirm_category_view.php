<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2004 
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once (t3lib_extMgm :: extPath('cal').'view/class.tx_cal_base_view.php');
require_once (t3lib_extMgm :: extPath('cal').'controller/class.tx_cal_calendar.php');

/**
 * A service which renders a form to create / edit a phpicalendar event.
 *
 * @author Mario Matzulla <mario(at)matzullas.de>
 */
class tx_cal_confirm_category_view extends tx_cal_base_view {

	
	/**
	 *  Draws a create category form.
	 *  @param		string		Comma separated list of pids.
	 *  @param		object		A location or organizer object to be updated
	 *	@return		string		The HTML output.
	 */
	function drawConfirmCategory(){	

		
		$page = $this->cObj->fileResource($this->conf['view.']['category.']['confirmCategoryTemplate']);
		if ($page=='') {
			return '<h3>category: no create category template file found:</h3>'.$this->conf['view.']['category.']['confirmCategoryTemplate'];
		}
		
		$languageArray = array();
		$form 	= $this->cObj->getSubpart($page, '###FORM_START###');
		$languageArray ['l_confirm_category'] = $this->controller->pi_getLL('l_confirm_category');
		if($this->rightsObj->isAllowedToEditCategoryHidden() || $this->rightsObj->isAllowedToCreateCategoryHidden()){
			$form 	.= $this->cObj->getSubpart($page, '###FORM_HIDDEN###');
			if ($this->controller->piVars['hidden'] == 'on') {
				$hidden = 'true';
			} else {
				$hidden = 'false';
			}
			$languageArray['l_hidden'] = $this->controller->pi_getLL('l_hidden');
			$languageArray['hidden'] = $this->controller->pi_getLL('l_'.$hidden);
		}
		
		if($this->rightsObj->isAllowedToEditCategoryTitle() || $this->rightsObj->isAllowedToCreateCategoryTitle()){
			$form 	.= $this->cObj->getSubpart($page, '###FORM_TITLE###');
			$languageArray['l_title'] = $this->controller->pi_getLL('l_event_title');
			$languageArray['title'] = strip_tags($this->controller->piVars['title']);
		}
		
		if($this->rightsObj->isAllowedToEditCategoryHeaderstyle() || $this->rightsObj->isAllowedToCreateCategoryHeaderstyle()){
			$form 	.= $this->cObj->getSubpart($page, '###FORM_HEADRSTYLE###');
			$languageArray['l_category_headerstyle'] = $this->controller->pi_getLL('l_event_headerstyle');
			$languageArray['headerstyle'] = strip_tags($this->controller->piVars['headerstyle']);
		}
		
		if($this->rightsObj->isAllowedToEditCategoryBodystyle() || $this->rightsObj->isAllowedToCreateCategoryBodystyle()){
			$form 	.= $this->cObj->getSubpart($page, '###FORM_BODYSTYLE###');
			$languageArray['l_category_bodystyle'] = $this->controller->pi_getLL('l_event_bodystyle');
			$languageArray['bodystyle'] = strip_tags($this->controller->piVars['bodystyle']);
		}
		
		$form 	.= $this->cObj->getSubpart($page, '###FORM_END###');
		$languageArray['uid'] = $this->conf['uid'];
		$languageArray['type'] = $this->conf['type'];
		$languageArray['l_submit'] = $this->controller->pi_getLL('l_submit');
		$languageArray['l_cancel'] = $this->controller->pi_getLL('l_cancel');
		$languageArray['action_url'] = $this->controller->pi_linkTP_keepPIvars_url(array('view'=>'save_category'));
		
		$page = $this->controller->replace_tags($languageArray,$form);		
		return $page;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cal/view/class.tx_cal_confirm_category_view.php']) {
	include_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cal/view/class.tx_cal_confirm_category_view.php']);
}
?>