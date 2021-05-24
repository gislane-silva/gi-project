## Sobre o projeto

O projeto foi desenvolvido através do framework Laravel 8
- [Documentation](https://laravel.com/docs/8.x).


## O que eu posso fazer com esta API?
- Cadastrar usuários;
- Realizar transferências entre usuários;

## Status HTTP que poderão ser retornados
- O status 200: processamento realizado com sucesso sem ressalvas;
- O status 400: algo fornecido da parte do usuário não corresponde com o esperado;
- O status 500: alguma validação da parte do servidor não ocorreu como planejado na requisição.

## Sobre os retornos
Retornos serão feitos em JSON. 
```
{
    message: 'Informando a mesnagem de erro ou sucesso'
}
```


## Rotas
### POST - Cadastrar Usuário
##### URL
- #### app.giproject.com.br/api/users
##### BODY
- #### name (string, required, min:3, max: 255)
  nome completo do usuário
- #### email (string, required)
  email do usuário
- #### password (string, required)
  senha
- #### password_confirmation (string, required)
  confirmação de senha
- #### cpf_cnpj (string, required)
  cpf ou cnpj do usuário
- #### user_type_enum (integer, required)
  - 1 usuário
  - 2 lojista

```
{
    name: 'Nome Sobrenome',
    email: 'exemplo@gmail.com',
    password: 'senhaaqui',
    password_confirmation: 'senhaaqui',
    cpf_cnpj: '12345678921' ou '123.456.789-21',
    user_type_enum: 1
}
```

### POST - Criar transferência
##### URL
- #### app.giproject.com.br/api/transactions
##### BODY
- #### payer (integer, required, max: 255)
  id do pagador
- #### payee (integer, required)
  id do beneficiário
- #### value (numeric, required)
  valor da transferência

```
{
    payer: 1
    payee: 2,
    value: 10.00
}
```

## Pontos de melhoria
- Implementação de testes unitários
- Salvar notificação que não conseguiu ser enviada para retentar mais tarde

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
