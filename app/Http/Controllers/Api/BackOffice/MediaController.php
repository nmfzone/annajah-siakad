<?php

namespace App\Http\Controllers\Api\BackOffice;

use App\Garages\ImageOptimizer\OptimizerChainFactory;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\MediaCollection;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Rules\WysiwygMediaModel;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function wysiwygMedia(Request $request)
    {
        $request->validate([
            'model' => ['required', new WysiwygMediaModel],
            'model_id' => [new WysiwygMediaModel($request->get('model'))],
        ]);

        $model = $this->mediaService->getModelForWysiwyg($request->get('model'));

        $query = Media::whereHasMorph('model', $model)
            ->where('user_id', $request->user()->id)
            ->where('site_id', optional(site())->id)
            ->latest();

        if (! is_null($modelId = $request->get('model_id'))) {
            $query->where('model_id', $modelId);
        } else {
            //
        }

        if (! empty($search = $request->get('q'))) {
            $query->where('name', 'like', $search . '%');
        }

        return new MediaCollection($query->paginate());
    }

    public function storeWysiwygMedia(Request $request)
    {
        $request->validate([
            'model' => ['required', new WysiwygMediaModel],
            'model_id' => [new WysiwygMediaModel($request->get('model'))],
            'file' => 'required|file|mimes:png,gif,jpg,jpeg|max:1000',
        ]);

        // Compress file.
        $optimizerChain = OptimizerChainFactory::create(['quality' => 60]);
        $optimizerChain->optimize($request->file('file')->path());

        if (! is_null($modelId = $request->get('model_id'))) {
            $model = $this->mediaService->getModelForWysiwyg($request->get('model'));
            $model = $model::find($modelId);
            $media = $model->addMedia($request->file('file'))->toMediaCollection('images');
        } else {
            [$model, $media] = DB::transaction(function () use ($request) {
                $model = $this->mediaService->createModelForWysiwyg(
                    $request->all(),
                    $request->get('model')
                );

                $media = $model->addMedia($request->file('file'))->toMediaCollection('images');

                return [$model, $media];
            });
        }

        $media->user()->associate(auth()->user());
        $media->site()->associate(site());
        $media->save();

        return (new MediaResource($media))->additional([
            'data' => [
                'model' => [
                    'id' => $model->id,
                ],
            ],
        ]);
    }
}
