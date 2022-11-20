<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Http\Requests\UpdateAttachmentRequest;
use App\Models\Attachment;
use App\Models\Idea;
use \Auth;

class AttachmentController extends Controller
{

	private $basedir = '../storage/app/files/';
	public function preview(Attachment $image) {
    echo file_get_contents($this->basedir . $image->pathinfo);exit;
	}

	private function genFileName($file) {
		$tmp = substr(base64_encode(random_bytes(32) . md5($file->getRealPath())), 0, -2);
		$tmp = str_replace("+", "", $tmp);
		$tmp = str_replace("/", "", $tmp);

		return $tmp;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttachmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Idea $idea, StoreAttachmentRequest $request)
    {
			foreach ($request->file('attachments') as $rf) {
				if( $rf->getError() === 0 ) {
					$obj = new Attachment();
					$obj->filesize = $rf->getSize();
					$obj->mime = $rf->getMimeType();
					$obj->originalName = $rf->getClientOriginalName();
					$obj->displayName = $rf->getClientOriginalName();
					$obj->pathinfo = $this->genFileName($rf);
					$obj->idea_id = $idea->id;
					$obj->creator_id = Auth::id();
					$obj->save();

					if( $obj->id ) {
						$rf->move($this->basedir, $obj->pathinfo);
					}
				}
			}

			return redirect()->route('idea.show', $idea);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttachmentRequest  $request
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttachmentRequest $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        //
    }
}
