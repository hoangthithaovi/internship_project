<?php

namespace App;
use DB;

trait FullTextSearch
{
    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if(strlen($word) >= 1) {
                $words[$key] = '+' . $word . '*';
            }
        }

        $searchTerm = implode( ' ', $words);

        return $searchTerm;
    }

    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term)
    {
        $columns = implode(',',$this->searchable);
        $query= DB::table('events')
                ->select('events.id as IDEvent', 'events.title_event','events.location',DB::raw('SUM(tickets.quantity) as total_ticket'),'events.description','events.date_start','events.date_end','attached_files.attached_file','attached_files.folder','events.status', 'events.created_at', 'events.updated_at')
                ->join('tickets', 'tickets.event_id', '=', 'events.id')

                ->join('attached_files', function ($join) {
                        $join->on('attached_files.object_id', '=', 'events.id')
                             ->where('attached_files.id',function ($q) {
                                $q->select(DB::raw('MAX(attached_files.id)'))
                                  ->from('attached_files')
                                  ->whereRaw('attached_files.object_id = events.id');
                        })  
                            ->where('attached_files.parent_object_id', '=', 2);
                })
                ->where('events.is_delete','=',0)
                ->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)" , $this->fullTextWildcards($term))
                ->groupBy('events.id','events.title_event', 'events.location', 'events.description', 'events.date_start', 'events.date_end', 'attached_files.attached_file', 'attached_files.folder', 'events.status','events.created_at', 'events.updated_at');
            return $query;
    }
}