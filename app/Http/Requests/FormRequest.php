<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * Merge rule with others.
     *
     * @param  array|string  $rule
     * @param  array  $newRule
     * @param  array  $excepts
     * @return array
     */
    public function mergeRule($rule, array $newRule, array $excepts = [])
    {
        $rule = empty($rule) ? [] : $rule;
        $rules = is_array($rule) ? $rule : explode('|', $rule);

        if (count($excepts) > 0) {
            $excepts = array_keys(Arr::where($excepts, function ($v) {
                return $v;
            }));

            // Unset rules that excepted.
            foreach ($rules as $key => $item) {
                if (in_array($key, $excepts, true)) {
                    unset($rules[$key]);
                }
            }
        }

        $finalNewRule = [];
        foreach ($newRule as $key => $rule) {
            if (! is_numeric($key) && $rule === true) {
                $finalNewRule[] = $key;
            } else {
                $finalNewRule[] = $rule;
            }
        }

        $rules = array_merge($rules, $finalNewRule);

        $orderedRules = ['bail', 'nullable', 'required'];

        $startRules = [];
        foreach ($orderedRules as $rule) {
            if (in_array($rule, $rules, true)) {
                unset($rules[array_search($rule, $rules)]);
                $startRules[] = $rule;
            }
        }

        return Arr::where(array_merge($startRules, $rules), function ($v) {
            return is_string($v) || is_object($v);
        });
    }

    /**
     * Merge the current rules with additional rules.
     *
     * @param  \Illuminate\Support\Collection|array  $rules
     * @param  array  $addRules
     * @param  array  $excepts
     * @return array
     */
    public function mergeRules($rules, array $addRules, $excepts = [])
    {
        if ($rules instanceof Collection) {
            $rules = $rules->toArray();
        }

        foreach ($rules as $key => $rule) {
            $rule = is_array($rule) ? $rule : explode('|', $rule);

            if (Arr::exists($addRules, $key)) {
                $rule = $addRules[$key];
            }

            if (in_array($key, $excepts)) {
                unset($rules[$key]);
            } else {
                $rules[$key] = $rule;
            }
        }

        // Then, we'll merge the new rule that didn't exists before.
        foreach ($addRules as $key => $rule) {
            if (! Arr::exists($rules, $key)) {
                $rules[$key] = $rule;
            }
        }

        return $rules;
    }
}
