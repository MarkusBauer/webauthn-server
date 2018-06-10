<?php


namespace MadWizard\WebAuthn\Dom;

use InvalidArgumentException;
use MadWizard\WebAuthn\Format\ByteBuffer;

class PublicKeyCredentialCreationOptions extends AbstractDictionary
{
    /**
     * @var PublicKeyCredentialRpEntity
     */
    private $rp;

    /**
     * @var PublicKeyCredentialUserEntity
     */
    private $user;

    /**
     * @var ByteBuffer
     */
    private $challenge;

    /**
     * @var int|null
     */
    private $timeout;

    /**
     * @var PublicKeyCredentialDescriptor[]
     */
    private $excludedCredentials = [];

    /*
        AuthenticatorSelectionCriteria               authenticatorSelection;
        AttestationConveyancePreference              attestation = "none";
        AuthenticationExtensionsClientInputs         extensions;
    */

    /**
     * @var PublicKeyCredentialParameters[]
     */
    private $pubKeyCredParams;

    // TODO
    private $authenticatorSelection;

    /**
     * @var string|null
     */
    private $attestation;

    // TODO
    private $extensions;

    /**
     * PublicKeyCredentialCreationOptions constructor.
     * @param PublicKeyCredentialRpEntity $rp
     * @param PublicKeyCredentialUserEntity $user
     * @param ByteBuffer $challenge
     * @param PublicKeyCredentialParameters[] $pubKeyCredParams
     */
    public function __construct(PublicKeyCredentialRpEntity $rp, PublicKeyCredentialUserEntity $user, ByteBuffer $challenge, array $pubKeyCredParams)
    {
        $this->rp = $rp;
        $this->user = $user;
        $this->challenge = $challenge;
        $this->pubKeyCredParams = $pubKeyCredParams;
    }

    public function getAsArray(): array
    {
        $map = [
            'rp' => $this->rp,
            'user' => $this->user,
            'challenge' => $this->challenge,
            'pubKeyCredParams' => $this->pubKeyCredParams
        ];

        if ($this->timeout !== null) {
            $map['timeout'] = $this->timeout;
        }

        if (\count($this->excludedCredentials) !== 0) {
            $map['excludedCredentials'] = $this->excludedCredentials;
        }

        if ($this->authenticatorSelection !== null) {
            $map['authenticatorSelection'] = $this->authenticatorSelection;
        }
        if ($this->attestation !== null) {
            $map['attestation'] = $this->attestation;
        }
        if ($this->extensions !== null) {
            $map['extensions'] = $this->extensions;
        }
        return $map;
    }

    /**
     * @return null|string
     */
    public function getAttestation(): ?string
    {
        return $this->attestation;
    }

    /**
     * @param null|string $attestation
     */
    public function setAttestation(?string $attestation): void
    {
        if ($attestation !== null && !AttestationConveyancePreference::isValidValue($attestation)) {
            throw new InvalidArgumentException(sprintf("String '%s' is not a valid attestation preference.", $attestation));
        }
        $this->attestation = $attestation;
    }
}
