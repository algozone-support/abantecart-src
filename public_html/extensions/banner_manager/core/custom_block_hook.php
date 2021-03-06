<?php
/*------------------------------------------------------------------------------
  $Id$

  AbanteCart, Ideal OpenSource Ecommerce Solution
  http://www.AbanteCart.com

  Copyright (c) 2011 Belavier Commerce LLC

  Released under the GNU General Public License
  Lincence details is bundled with this package in the file LICENSE.txt.
  It is also available at this URL:
  <http://www.gnu.org/licenses/>

 UPGRADE NOTE:
   Do not edit or add to this file if you wish to upgrade AbanteCart to newer
   versions in the future. If you wish to customize AbanteCart for your
   needs please refer to http://www.AbanteCart.com for more information.
------------------------------------------------------------------------------*/
if (!defined('DIR_CORE')) {
	header('Location: static_pages/');
}

class ExtensionBannerManager extends Extension {
	private $registry;

	public function __construct(){
		$this->registry = Registry::getInstance();
	}
	public function __get($key) {
		return $this->registry->get($key);
	}


	public function onControllerPagesDesignBlocks_InitData() {
		$method_name = func_get_arg(0);
		if($method_name=='insert'){
			$lm = new ALayoutManager();
			$this->baseObject->loadLanguage('banner_manager/banner_manager');
			$this->baseObject->loadLanguage('design/blocks');
			$block = $lm->getBlockByTxtId('banner');
			$block_id = $block['block_id'];

			$this->baseObject->data['tabs'][1000] = array( 'href'=> $this->html->getSecureURL('extension/banner_manager/insert_block', '&block_id=' . $block_id),
														   'text' => $this->language->get('text_banner_block'),
														   'active'=>false);
		}
		if($method_name=='edit'){
			$lm = new ALayoutManager();
			$blocks = $lm->getAllBlocks();

			foreach ($blocks as $block) {
				if ($block[ 'custom_block_id' ] == (int)$this->request->get['custom_block_id']) {
					$block_txt_id = $block[ 'block_txt_id' ];
					break;
				}
			}

			if($block_txt_id=='banner_block'){
				header('Location: ' .$this->html->getSecureURL('extension/banner_manager/edit_block', '&custom_block_id=' . (int)$this->request->get['custom_block_id']));
				exit;
			}
		}
	}

}