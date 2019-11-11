<?php

namespace Fhp\Response;

use Fhp\Model;
use Fhp\Segment\HITAN\HITANv6;

class GetTANRequest extends Response implements \Serializable
{
    const SEG_ACCOUNT_INFORMATION = 'HITAN';
	
    /**
     * Returns TANRequest object with process ID
     *
     * @return Model\TANRequest
     */
    public function get()
    {
        /** @var HITANv6 $segment */
        $segment = $this->getSegment(static::SEG_ACCOUNT_INFORMATION);

		$request = new Model\TANRequest(
            $segment->getAuftragsReferenz()
        );
		
		return $request;
    }

    /**
     * @return string
     */
    public function serialize() {

        // Implements "Serializable" because $this->dialog should not be serialized
        // as long as Dialog depends directly on Connection

        return base64_encode(serialize(array(
            'rawResponse' => $this->rawResponse,
            'response' => $this->response,
            'segments' => $this->segments,
            'dialogState' => Model\DialogState::createFrom($this->getDialog()),
        )));
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized) {

        $data = unserialize(base64_decode($serialized));

        $this->rawResponse = $data['rawResponse'];
        $this->response = $data['response'];
        $this->segments = $data['segments'];
        $this->dialogState = $data['dialogState'];
    }

    private $dialogState = null;

    /**
     * @return Model\DialogState
     */
    public function getDialogState() {
        return $this->dialogState;
    }

    public function setDialog($dialog) {
        $this->dialog = $dialog;
    }

    /**
     * @return string
     */
    public function getTanChallenge() {

        /** @var HITANv6 $segment */
        $segment = $this->getSegment(static::SEG_ACCOUNT_INFORMATION);
        if($segment->getChallenge() != "") {
            return $segment->getChallenge();
        }

        return "";
    }

    /**
     * @return Model\TanRequestChallengeImage|null
     */
    public function getTanChallengeImage() {

        /** @var HITANv6 $segment */
        $segment = $this->getSegment(static::SEG_ACCOUNT_INFORMATION);

        if($segment->getChallengeHDD_UC() === null) {
            return null;
        }

        return new Model\TanRequestChallengeImage($segment->getChallengeHDD_UC());
    }
}
