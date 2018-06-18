<?php
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
		$oPage->add('<iframe id="'.$sId.'" width="'.$iWidth.'" height="'.$iHeight.'" frameborder="0" src="'.$sUrl.'"></iframe>');
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