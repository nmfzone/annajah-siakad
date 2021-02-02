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
    public function mergeRule($rule, array $newRule, array $excepts = []): array
    {
        $rule = empty($rule) ? [] : $rule;
        $rules = is_array($rule) ? $rule : explode('|', $rule);

        if (count($excepts) > 0) {
            // Filter 'excepts' based on it's value
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
     * @param  array  $changedRules
     * @param  array  $excepts
     * @return array
     */
    public function mergeRules($rules, array $changedRules, $excepts = []): array
    {
        if ($rules instanceof Collection) {
            $rules = $rules->toArray();
        }

        // Filter 'excepts' based on it's value
        $excepts = array_keys(Arr::where($excepts, function ($v) {
            return $v;
        }));

        // Unset rules that excepted.
        foreach ($rules as $key => $rule) {
            if (in_array($key, $excepts, true)) {
                unset($rules[$key]);
            }
        }

        foreach ($changedRules as $key => $rule) {
            if ($rule !== false) {
                $rules[$key] = $rule;
            } else {
                unset($rules[$key]);
            }
        }

        return $rules;
    }
}
