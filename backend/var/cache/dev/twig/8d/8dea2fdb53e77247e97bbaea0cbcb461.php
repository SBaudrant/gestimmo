<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* email/account_created.html.twig */
class __TwigTemplate_1f62e909c9db14d70a56f9c71c4b4af7 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "email/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "email/account_created.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "email/account_created.html.twig"));

        $this->parent = $this->loadTemplate("email/base.html.twig", "email/account_created.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "  <p>";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("NewUser.Email.Content.Hello", ["%name%" => ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 4, $this->source); })()), "firstName", [], "any", false, false, false, 4) . " ") . twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 4, $this->source); })()), "lastName", [], "any", false, false, false, 4))], "messages");
        echo ",</p>

  <p>";
        // line 6
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("NewUser.Email.Content.AccountCreated", [], "messages");
        echo ".</p>
  <p>";
        // line 7
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("NewUser.Email.Content.ClickToFinish", [], "messages");
        echo ".</p>
  <p><a href=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["setPasswordUrl"]) || array_key_exists("setPasswordUrl", $context) ? $context["setPasswordUrl"] : (function () { throw new RuntimeError('Variable "setPasswordUrl" does not exist.', 8, $this->source); })()), "html", null, true);
        echo "\">";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("NewUser.Email.Content.ActivateNow", [], "messages");
        echo "</a>.</p>

  <p>";
        // line 10
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("NewUser.Email.Content.RawLink", [], "messages");
        echo " : <span>";
        echo twig_escape_filter($this->env, (isset($context["setPasswordUrl"]) || array_key_exists("setPasswordUrl", $context) ? $context["setPasswordUrl"] : (function () { throw new RuntimeError('Variable "setPasswordUrl" does not exist.', 10, $this->source); })()), "html", null, true);
        echo "</span>.</p>

  <p>";
        // line 12
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("NewUser.Email.Content.Regards", [], "messages");
        echo ",</p>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "email/account_created.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 12,  89 => 10,  82 => 8,  78 => 7,  74 => 6,  68 => 4,  58 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'email/base.html.twig' %}

{% block body %}
  <p>{% trans with {'%name%': user.firstName ~ ' ' ~ user.lastName} %}NewUser.Email.Content.Hello{% endtrans %},</p>

  <p>{% trans %}NewUser.Email.Content.AccountCreated{% endtrans %}.</p>
  <p>{% trans %}NewUser.Email.Content.ClickToFinish{% endtrans %}.</p>
  <p><a href=\"{{ setPasswordUrl }}\">{% trans %}NewUser.Email.Content.ActivateNow{% endtrans %}</a>.</p>

  <p>{% trans %}NewUser.Email.Content.RawLink{% endtrans %} : <span>{{ setPasswordUrl }}</span>.</p>

  <p>{% trans %}NewUser.Email.Content.Regards{% endtrans %},</p>
{% endblock %}
", "email/account_created.html.twig", "/srv/php/templates/email/account_created.html.twig");
    }
}
