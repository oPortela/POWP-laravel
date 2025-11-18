-- Este script cria uma função no Supabase que executa todas as inserções
-- dentro de uma única transação.
-- Se qualquer passo falhar, tudo é desfeito (rollback).

CREATE OR REPLACE FUNCTION criar_cliente_completo(
    -- Parâmetros do Endereço
    p_logradouro VARCHAR, p_numero VARCHAR, p_cep VARCHAR, p_bairro VARCHAR, p_cidade VARCHAR, p_estado VARCHAR,
    
    -- Parâmetros do Telefone
    p_telefone VARCHAR, p_celular VARCHAR,
    
    -- Parâmetros do Cliente
    p_cliente VARCHAR, p_fantasia VARCHAR, p_tipopessoa VARCHAR, p_email VARCHAR, p_obs VARCHAR, p_bloqueio VARCHAR, p_motivo_bloq VARCHAR,
    
    -- Parâmetros de Pessoa Física
    p_cpf VARCHAR, p_rg VARCHAR, p_dt_nascimento DATE,
    
    -- Parâmetros de Pessoa Jurídica
    p_cnpj VARCHAR, p_inscricaoestadual VARCHAR, p_dtabertura DATE
)
RETURNS pwcliente -- Retorna a linha do cliente que foi criado
LANGUAGE plpgsql
-- SECURITY DEFINER é importante para que a função possa escrever em tabelas
-- que o usuário anônimo/autenticado talvez não tenha permissão direta.
SECURITY DEFINER 
AS $$
DECLARE
    v_codendereco BIGINT;
    v_codtelefone BIGINT;
    v_cliente_criado pwcliente;
BEGIN
    -- 1. Inserir Endereço e pegar o ID
    INSERT INTO public.pwendereco (logradouro, numero, cep, bairro, cidade, estado)
    VALUES (p_logradouro, p_numero, p_cep, p_bairro, p_cidade, p_estado)
    RETURNING codendereco INTO v_codendereco;

    -- 2. Inserir Telefone e pegar o ID
    INSERT INTO public.pwtelefone (telefone, celular)
    VALUES (p_telefone, p_celular)
    RETURNING codtelefone INTO v_codtelefone;

    -- 3. Inserir Cliente
    INSERT INTO public.pwcliente (cliente, fantasia, dtcadastro, tipopessoa, email, codendereco, codtelefone, obs, bloqueio, motivo_bloq)
    VALUES (p_cliente, p_fantasia, now(), p_tipopessoa, p_email, v_codendereco, v_codtelefone, p_obs, p_bloqueio, p_motivo_bloq)
    RETURNING * INTO v_cliente_criado; -- Salva a linha do cliente criado na variável

    -- 4. Inserir Tipo de Pessoa
    IF p_tipopessoa = 'F' THEN
        INSERT INTO public.pwclientefisico (codcli, cpf, rg, dt_nascimento)
        VALUES (v_cliente_criado.codcliente, p_cpf, p_rg, p_dt_nascimento);
    ELSIF p_tipopessoa = 'J' THEN
        INSERT INTO public.pwclientejuridico (codcli, cnpj, inscricaoestadual, dtabertura)
        VALUES (v_cliente_criado.codcliente, p_cnpj, p_inscricaoestadual, p_dtabertura);
    END IF;
    
    -- 5. Retornar o cliente que foi criado
    RETURN v_cliente_criado;

-- O bloco EXCEPTION garante o rollback
EXCEPTION
    WHEN OTHERS THEN
        -- Se qualquer um dos INSERTS acima falhar,
        -- a transação é desfeita e o erro é retornado.
        RAISE;
END;
$$;