<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model
{
	protected $table = 'exams_subjects';
	protected $fillable = ['subject_id','exam_id','career_id'];

	public $timestamps = false;
    public function subject()
    {
        return $this->belongsTo('Institute\Subject');
    }
    public function career()
    {
        return $this->belongsTo('Institute\Career');
    }
    public function exam()
    {
        return $this->belongsTo('Institute\Exam');
    }
}
