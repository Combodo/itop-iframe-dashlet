<?php
/*
 * @copyright   Copyright (C) 2010-2021 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

use Combodo\iTop\Application\UI\Base\Component\Html\Html;
use Combodo\iTop\Application\UI\Base\Layout\UIContentBlockUIBlockFactory;

class DashletIFrame extends Dashlet
{
	public function __construct($oModelReflection, $sId)
	{
		parent::__construct($oModelReflection, $sId);
		$this->aProperties['url'] = '';
		$this->aProperties['width'] = 600;
		$this->aProperties['height'] = 650;
		$this->aCSSClasses[] = 'dashlet-inline';
		
	}

	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sUrl = $this->aProperties['url'];
		$iWidth = (int) $this->aProperties['width'];
		$iHeight = (int) $this->aProperties['height'];
		$sId = utils::GetSafeId('dashlet_iframe_'.($bEditMode? 'edit_' : '').$this->sId);

		if (version_compare(ITOP_DESIGN_LATEST_VERSION , 3.0) < 0) {
			$oPage->add('<div class="dashlet-content">');
			$oPage->add('<iframe id="'.$sId.'" style="max-width: 100%;" width="'.$iWidth.'" height="'.$iHeight.'" frameborder="0" src="'.$sUrl.'"></iframe>');
			if($bEditMode)
	        {
	            $oPage->add('<div style="width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; cursor: not-allowed;"></div>');
	        }
	        $oPage->add('</div>');
			return null;
		} else {
			$oBlock = UIContentBlockUIBlockFactory::MakeStandard(null, ["dashlet-content"]);
			$oBlock->AddSubBlock(new Html('<iframe id="'.$sId.'" style="max-width: 100%;" width="'.$iWidth.'" height="'.$iHeight.'" frameborder="0" src="'.$sUrl.'"></iframe>'));
			if ($bEditMode) {
				$oBlock->AddSubBlock(UIContentBlockUIBlockFactory::MakeStandard(null, ["frame-view-blocker"]));
			}
			return $oBlock;
		}
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerLongTextField('url', Dict::S('UI:DashletIframe:Prop-Url'), $this->aProperties['url']);
		$oField->SetMandatory();
		$oForm->AddField($oField);
		
		$oField = new DesignerIntegerField('width', Dict::S('UI:DashletIframe:Prop-Width'), $this->aProperties['width']);
		$oField->SetMandatory();
		$oForm->AddField($oField);
		
		$oField = new DesignerIntegerField('height', Dict::S('UI:DashletIframe:Prop-Height'), $this->aProperties['height']);
		$oField->SetMandatory();
		$oForm->AddField($oField);
	}

	static public function GetInfo()
	{
		return array(
				'label' => Dict::S('UI:DashletIframe:Label'),
				'icon' => 'env-'.utils::GetCurrentEnvironment().'/itop-iframe-dashlet/images/iframe.png',
				'description' => Dict::S('UI:DashletIframe:Description'),
		);
	}
}