<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel) {
        $this->authorize('edit', $channel);

        return view('channel.settings.edit', [
            'channel' => $channel
        ]);
    }

    public function update(ChannelUpdateRequest $updateRequest, Channel $channel) {
        $this->authorize('update', $channel);

        $channel->update([
            'name' => $updateRequest->name,
            'slug' => $updateRequest->slug,
            'description' => $updateRequest->description,
        ]);

        return redirect()->to('/channel/' . $channel->slug . '/edit');
    }
}
