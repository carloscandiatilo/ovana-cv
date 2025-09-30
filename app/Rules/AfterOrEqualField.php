<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AfterOrEqualField implements ValidationRule
{
    public function __construct(
        protected string $fieldName,
        protected string $fieldLabel = 'campo de comparação'
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        // Extrai o caminho base do repeater (ex: 'formacoes_academicas.0')
        $parts = explode('.', $attribute);
        array_pop($parts); // remove o nome do campo atual (ex: 'ano_fim')
        $basePath = implode('.', $parts);

        // Monta o caminho do campo irmão
        $siblingPath = $basePath . '.' . $this->fieldName;

        // Obtém o valor do campo irmão a partir dos dados de validação
        $siblingValue = data_get($this->context['data'] ?? [], $siblingPath);

        if ($siblingValue === null || $siblingValue === '') {
            return;
        }

        if ((int) $value < (int) $siblingValue) {
            $fail("O valor deve ser maior ou igual ao do campo {$this->fieldLabel}.");
        }
    }

    public function withValidator($validator): void
    {
        $this->context = $validator->getData();
    }
}