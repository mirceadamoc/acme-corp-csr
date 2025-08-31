<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CampaignController extends Controller {
  public function index(Request $request) {
    $q = (string)$request->query('q','');
    $campaigns = Campaign::query()
      ->when($q !== '', fn($qry)=>$qry->where('title','like',"%{$q}%")->orWhere('description','like',"%{$q}%"))
      ->latest()->paginate(10)->withQueryString();
    return Inertia::render('Campaigns/Index', ['campaigns'=>$campaigns,'filters'=>['q'=>$q]]);
  }
  public function create() { return Inertia::render('Campaigns/Create'); }
  public function store(StoreCampaignRequest $request) {
    $data = $request->validated(); $data['user_id'] = $request->user()->id; $data['current_amount']=0;
    $c = Campaign::query()->create($data);
    return redirect()->route('campaigns.show',$c->id)->with('success','Campaign created.');
  }
  public function show(Campaign $campaign) {
    $campaign->loadCount('donations');
    return Inertia::render('Campaigns/Show', ['campaign'=>$campaign]);
  }
}
