<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $options = view('admin.projects.partials.options', ['instance' => $this])->render();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'client' => isset($this->advocateClient) ? $this->advocateClient->name : $this->owner_name,
            'options' => $options,
        ];
    }
}
