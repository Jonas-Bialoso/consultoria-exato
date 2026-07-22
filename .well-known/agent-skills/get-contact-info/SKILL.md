# GetContactInfo

## Description
Retrieve contact information and instructions for requesting a quote or consulting engagement from Consultoria Exato.

## Parameters
- `language` (string, optional): Response language. Accepted values: `"pt-BR"`, `"en-US"`. Default: `"pt-BR"`.

## Behavior
Returns structured contact data for Consultoria Exato. No authentication required.

## Contact Data

| Field | Value |
|---|---|
| Company | Exato Soluções Ocupacionais e Ambientais Ltda. |
| Trade name | Consultoria Exato |
| Principal | Paulo Cassim |
| Email | contato@consultoriaexato.com.br |
| WhatsApp | +55 16 99788-8750 |
| Location | Ribeirão Preto, SP, Brazil |
| Website (PT) | https://consultoriaexato.com.br/ |
| Website (EN) | https://consultoriaexato.com.br/en/ |
| LinkedIn | https://www.linkedin.com/in/pcassim/ |

## How to Request a Quote
1. Send a WhatsApp message to +55 16 99788-8750
2. Or email contato@consultoriaexato.com.br
3. Or use the contact form at https://consultoriaexato.com.br/#contact

## Service Coverage
State of São Paulo, Brazil (on-site). Remote consulting available nationwide.

## Example Response
```json
{
  "company": "Exato Soluções Ocupacionais e Ambientais Ltda.",
  "trade_name": "Consultoria Exato",
  "contact": {
    "email": "contato@consultoriaexato.com.br",
    "whatsapp": "+5516997888750",
    "website_pt": "https://consultoriaexato.com.br/",
    "website_en": "https://consultoriaexato.com.br/en/"
  },
  "location": "Ribeirão Preto, SP, Brazil"
}
```
