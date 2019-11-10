<?php

namespace Fhp\Response;

use Fhp\Model;
use Fhp\Segment\HITAN\HITANv6;

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
