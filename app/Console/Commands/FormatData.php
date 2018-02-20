<?php

namespace App\Console\Commands;

use App\ModelHelpers\NovelHelper;
use App\Models\Chapter;
use App\Models\Novel;
use Illuminate\Console\Command;

class FormatData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("begin");
        $novels = NovelHelper::getNovels([],'id asc',20);
        foreach($novels as $novel){
            $chapters = Chapter::where('novel_id', $novel->id)
                ->orderBy('chapter_id','asc')
                ->get(['id','chapter_id','novel_id']);
            $i = 1;
            foreach($chapters as $chapter){
                $chapter->chapter_id = $i;
                $chapter->save();
                $i++;
                unset($chapter);
            }
            unset($chapters);
            unset($novel);
        }
        $this->info("finished");
    }
}
