<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreCampaignRequest extends FormRequest {
  public function authorize(): bool { return $this->user() !== null; }
  public function rules(): array {
    return [
      'title'=>['required','string','max:255'],
      'description'=>['required','string'],
      'goal_amount'=>['required','numeric','min:1'],
      'starts_at'=>['nullable','date'],
      'ends_at'=>['nullable','date','after_or_equal:starts_at'],
      'status'=>['nullable','in:draft,active,closed'],
    ];
  }
}
