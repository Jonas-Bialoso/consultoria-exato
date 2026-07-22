---
layout: default
title: Consultoria Exato — correção dos links 404
---

# Correção dos links de post que dão 404

Os links de post gerados na **raiz** do `consultoriaexato.com.br` caem em 404,
porque o blog (WordPress) vive em `/blog/` e a raiz é outro servidor (Locaweb).
A correção é um **redirect 301** aplicado **na raiz do domínio ou no Cloudflare** —
não dá para fazer por plugin do WordPress.

## Documentos

- **[Diagnóstico completo e as duas opções de correção](LEIA-ME.html)**
  O porquê do problema, as evidências dos testes, as opções A (`.htaccess`) e B
  (Cloudflare), e como testar depois de aplicar.

- **[Pedido pronto para enviar a quem tem acesso](HANDOFF-para-quem-tem-acesso.html)**
  Mensagem já redigida para mandar a quem administra a hospedagem Locaweb ou o
  painel do Cloudflare. É só escolher uma das duas opções e seguir o passo a passo.

- **[Bloco `.htaccess` pronto](redirect-raiz-para-blog.htaccess)**
  O arquivo com o bloco de redirect comentado, para colar no `.htaccess` da raiz.

## Resumo em uma linha

`consultoriaexato.com.br/{slug}` → **301** → `consultoriaexato.com.br/blog/{slug}/`
