<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreDonationRequest extends FormRequest {
  public function authorize(): bool { return $this->user() !== null; }
  public function rules(): array { return ['campaign_id'=>['required','exists:campaigns,id'],'amount'=>['required','numeric','min:1']]; }
}
