<?php
namespace Magentomaster\Testmodule\Model;

class UploaderPool
{
    /**
     * Available Uploaders
     *
     * @var array
     */
    protected $uploaders = [];

    /**
     * constructor
     *
     * @param array $uploaders
     */
    public function __construct(
        array $uploaders = []
    ) {
        $this->uploaders = $uploaders;
    }

    /**
     * @param string $type
     * @return \Magentomaster\Testmodule\Model\Uploader
     * @throws \Exception
     */
    public function getUploader($type)
    {
        if (!isset($this->uploaders[$type])) {
            throw new \Exception("Uploader not found for type: ".$type);
        }
        $uploader = $this->uploaders[$type];
        if (!($uploader instanceof \Magentomaster\Testmodule\Model\Uploader)) {
            throw new \Exception("Uploader for type {$type} not instance of ". \Magentomaster\Testmodule\Model\Uploader::class);
        }
        return $uploader;
    }
}
