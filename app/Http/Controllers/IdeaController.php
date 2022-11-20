<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use Illuminate\Http\Request;
use App\Models\Idea;
use App\Models\Attachment;
use App\Models\Area;
use \Auth;

class IdeaController extends Controller
{
		private $basedir = '../storage/app/files/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('home');
    }

		// Full list of Ideas without map
		public function list(Request $request) {
			$sort = $request->input('sorting') ?? 'time';
			$sort = strtolower($sort);
			$allowed = array('time', 'upvotes');
			if( !in_array($sort, $allowed) ) {
				$sort = 'time';
			}

			if( $sort == 'time' ) {
				$ideas = Idea::newest();
			} elseif( $sort == 'upvotes' ) {
				$ideas = Idea::upvotes();
			}

			return view('ideas')
				->with('ideas', $ideas)
				->with('sort', $sort);
		}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newidea');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIdeaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIdeaRequest $request)
    {
        $idea = new Idea($request->all());
				$idea->issuer()->associate(\Auth::user());
				$idea->save();

				$area = Area::where('label', '=', $idea->quarter);
				if( $area->count() == 0 ) {
					$area = new Area(array('label' => $idea->quarter));
					$area->parent_id = 1;
					$area->save();
				}
				$idea->area()->associate($area);


				if(null !== $request->file('attachments') ) {
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
				}

				flash()->success("Idea saved successfully!");

				return redirect()->route('home');
    }

		private function genFileName($file) {
			$tmp = substr(base64_encode(random_bytes(32) . md5($file->getRealPath())), 0, -2);
			$tmp = str_replace("+", "", $tmp);
			$tmp = str_replace("/", "", $tmp);

			return $tmp;
		}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function show(Idea $idea)
    {
        return view('idea')->with('idea', $idea);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIdeaRequest  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        //
    }
}
