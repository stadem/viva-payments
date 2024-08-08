<?php

namespace Stadem\VivaPayments\Enums;

/**
 * @see https://developer.vivawallet.com/integration-reference/response-codes/#statusid-parameter
 */
enum TransactionStatus: string
{
    /** The transaction has been completed successfully (PAYMENT SUCCESSFUL) */
    case PaymentSuccessful = 'F';

    /** The transaction is in progress (PAYMENT PENDING) */
    case PaymentPending = 'A';

    /**
     * The transaction has been captured
     * (the C status refers to the original pre-auth transaction which has now been captured;
     * the capture will be a separate transaction with status F)
     */
    case Captured = 'C';

    /** The transaction was not completed successfully (PAYMENT UNSUCCESSFUL) */
    case Error = 'E';

    /** The transaction has been fully or partially refunded */
    case Refunded = 'R';

    /** The transaction was cancelled by the merchant */
    case Cancelled = 'X';

    /** The cardholder has disputed the transaction with the issuing Bank */
    case Disputed = 'M';

    /** Dispute Awaiting Response */
    case DisputeAwaiting = 'MA';

    /** Dispute in Progress */
    case DisputeInProgress = 'MI';

    /** A disputed transaction has been refunded (Dispute Lost) */
    case DisputeLost = 'ML';

    /** Dispute Won */
    case DisputeWon = 'MW';

    /** Suspected Dispute */
    case DisputeSuspected = 'MS';


    public static function fromName(string $name): string
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status->value;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum " . self::class );
    }


    public static function fromValue(string $value): string
    {
        foreach (self::cases() as $status) {
            if( $value === $status->value ){
                return $status->name;
            }
        }
        throw new \ValueError("$value is not a valid backing value for enum " . self::class );
    }





}