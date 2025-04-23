<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Jobs\DeleteRejectedQuote;
use App\Traits\HttpResponse;

class AdminController extends Controller
{
    use HttpResponse;

    public function validateQuote($id)
    {
        $quote = Quote::withoutGlobalScopes()->find($id);

        if (!$quote) {
            return $this->error('Quote not found', 404);
        }
        $quote->update([
            'status' => 'validated'
        ]);

        return $this->success(
            $quote,
            'Quote validated successfully'
        );
    }

    public function rejectQuote($id)
    {
        $quote = Quote::withoutGlobalScopes()->find($id);

        if (!$quote) {
            return $this->error('Quote not found', 404);
        }
        $quote->update([
            'status' => 'rejected'
        ]);

        DeleteRejectedQuote::dispatch($quote)
            ->delay(now()->addMinutes(5));

        return $this->success(
            $quote,
            'Quote rejected successfully and will be deleted in 5 minutes'
        );
    }
}
