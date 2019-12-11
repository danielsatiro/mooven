<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $table = 'repositories';
    protected $primaryKey = 'id';
    protected $fillable = ['user','name'];
    protected $hidden = ['updated_at', 'created_at', 'login'];
    protected $appends = ['html_url'];

    public function getHtmlUrlAttribute() : string
    {
        return config('app.github.html_url') . "/{$this->user}/{$this->name}";
    }

    public static function validateUserRepository(array $data, string $type = 'C') : \Illuminate\Validation\Validator
    {
        $rules = [
            'user' => 'required|string|max:100',
            'name' => ['required','string','max:100',
                        \Illuminate\Validation\Rule::unique('repositories')->where(function ($query) use ($data) {
                            return $query->where('user', $data['user'])
                                    ->where('name', $data['name']);
                        })],
        ];
        if ($type == 'U') {
            $rules['id'] = 'required|integer|exists:repositories,id';
        }
        return \Validator::make($data, $rules);
    }

    public static function create(array $data)
    {
        $validate = self::validateUserRepository($data);

        if ($validate->fails()){
            throw new \Exception($validate->messages()->__toString(), 412);
        }

        $repos = new self;
        $repos->fill($data);
        $repos->save();

        return $repos;
    }
}
