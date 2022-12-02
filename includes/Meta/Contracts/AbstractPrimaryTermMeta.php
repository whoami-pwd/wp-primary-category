<?php

namespace EvigDev\PrimaryCategory\Meta\Contracts;

use EvigDev\PrimaryCategory\Admin\AdminPageAnalizer;
use EvigDev\PrimaryCategory\Admin\Contracts\SavePostInterface;
use EvigDev\PrimaryCategory\Enqueue\Contracts\ScriptInterface;
use EvigDev\PrimaryCategory\Enqueue\ScriptEnqueuer;
use EvigDev\PrimaryCategory\Template\Contracts\AbstractTemplate;
use EvigDev\PrimaryCategory\Template\Contracts\TemplateLoaderInterface;
use EvigDev\PrimaryCategory\Template\TemplateLoader;

abstract class AbstractPrimaryTermMeta implements MetaInterface, SavePostInterface, ScriptInterface, TemplateLoaderInterface {








    protected const NAME          = '';
    protected const POST_TYPES    = [];
    protected const SCRIPT_HANDLE = '';
    protected const SCRIPT_FILE   = '';

    protected AdminPageAnalizer $pageAnalizer;
    protected ScriptEnqueuer $scriptEnqueuer;
    protected TemplateLoader $templateLoader;


    public function __construct( AdminPageAnalizer $pageAnalizer, ScriptEnqueuer $scriptEnqueuer, TemplateLoader $templateLoader )     {
		$this->pageAnalizer   = $pageAnalizer;
		$this->scriptEnqueuer = $scriptEnqueuer;
		$this->templateLoader = $templateLoader;
	}

	public function getName(): string
	{
		return static::NAME;
	}

	public function getPostTypes(): array
	{
		return static::POST_TYPES;
	}

	public function enqueueScript( string $hook_suffix ): void
	{
		if (  ! $this->correctAdminPage() ) {
			return;
		}

		$this->scriptEnqueuer->enqueueScript(
			static::SCRIPT_HANDLE,
			static::SCRIPT_FILE,
		);

		$id = get_the_ID();
		if (  ! $id ) {
			return;
		}

		wp_localize_script(
			static::SCRIPT_HANDLE,
			'EvigDev',
			[
				static::NAME => $this->getMeta( $id ),
			]
		);

	}

	public function loadTemplate(): void
	{
		if (  ! $this->correctAdminPage() ) {
			return;
		}

		$this->templateLoader->loadPluginTemplate( $this->getTemplate() );
	}

	protected function correctAdminPage(): bool
	{
		return $this->getPostTypes() && $this->pageAnalizer->isTargetAdminPage( $this->getPostTypes() );
	}

	abstract protected function getTemplate(): AbstractTemplate;

	public function getMeta( int $postId ): int
	{
		return get_post_meta( $postId, static::NAME, true );
	}


}
