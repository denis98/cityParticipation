<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoteRequest;
use App\Http\Requests\UpdateVoteRequest;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Idea;
use Auth;
use Illuminate\Database\QueryException;

class VoteController extends Controller
{

	public function vote(Idea $idea, Request $request) {
		$accepted = array('up', 'down');
		if( !in_array($request->input('voting'), $accepted) ) {
			abort(403);
		}

		if( Auth::id() == $idea->issuer_id ) {
			abort(403);
		}

		$vote;
		if( $request->input('voting') == 'up' ) {
			$vote = 1;
		} else {
			$vote = 2;
		}

		try {
			$v = new Vote(array(
				'voter_id' => Auth::id(),
				'idea_id' => $idea->id,
				'voting' => $vote
			));
			$v->save();
		} catch(QueryException $e) {
			$v = Vote::where('voter_id', Auth::id())->where('idea_id', $idea->id)->first();
			$v->voting = $vote;
			$v->save();
		}

		return $vote;
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
     * @param  \App\Http\Requests\StoreVoteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVoteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVoteRequest  $request
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVoteRequest $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }
}
