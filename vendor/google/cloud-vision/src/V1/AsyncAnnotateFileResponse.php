<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/vision/v1/image_annotator.proto

namespace Google\Cloud\Vision\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The response for a single offline file annotation request.
 *
 * Generated from protobuf message <code>google.cloud.vision.v1.AsyncAnnotateFileResponse</code>
 */
class AsyncAnnotateFileResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The output location and metadata from AsyncAnnotateFileRequest.
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.OutputConfig output_config = 1;</code>
     */
    private $output_config = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Vision\V1\OutputConfig $output_config
     *           The output location and metadata from AsyncAnnotateFileRequest.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Vision\V1\ImageAnnotator::initOnce();
        parent::__construct($data);
    }

    /**
     * The output location and metadata from AsyncAnnotateFileRequest.
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.OutputConfig output_config = 1;</code>
     * @return \Google\Cloud\Vision\V1\OutputConfig
     */
    public function getOutputConfig()
    {
        return isset($this->output_config) ? $this->output_config : null;
    }

    public function hasOutputConfig()
    {
        return isset($this->output_config);
    }

    public function clearOutputConfig()
    {
        unset($this->output_config);
    }

    /**
     * The output location and metadata from AsyncAnnotateFileRequest.
     *
     * Generated from protobuf field <code>.google.cloud.vision.v1.OutputConfig output_config = 1;</code>
     * @param \Google\Cloud\Vision\V1\OutputConfig $var
     * @return $this
     */
    public function setOutputConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Vision\V1\OutputConfig::class);
        $this->output_config = $var;

        return $this;
    }

}

