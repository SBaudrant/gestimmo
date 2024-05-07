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

/* email/init_password.html.twig */
class __TwigTemplate_158ba968d80d87ae23250af7fb43af02 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "email/init_password.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "email/init_password.html.twig"));

        $this->parent = $this->loadTemplate("email/base.html.twig", "email/init_password.html.twig", 1);
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
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("InitPassword.Mail.Content.Hello", ["%name%" => ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 4, $this->source); })()), "firstName", [], "any", false, false, false, 4) . " ") . twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 4, $this->source); })()), "lastName", [], "any", false, false, false, 4))], "messages");
        echo ",</p>

  <p>";
        // line 6
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("InitPassword.Mail.Content.ClickLinkToChangePassword", [], "messages");
        echo "</p>
  <p>
    <a href=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["setPasswordUrl"]) || array_key_exists("setPasswordUrl", $context) ? $context["setPasswordUrl"] : (function () { throw new RuntimeError('Variable "setPasswordUrl" does not exist.', 8, $this->source); })()), "html", null, true);
        echo "\">";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("InitPassword.Mail.Content.UpdateNow", [], "messages");
        echo "</a>.
  </p>

  <p>";
        // line 11
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("InitPassword.Mail.Content.AccountStillSecure", [], "messages");
        echo "</p>

  <p>";
        // line 13
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("InitPassword.Mail.Content.UpdatePasswordIfCompromised", [], "messages");
        echo "</p>

  <p>";
        // line 15
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("InitPassword.Mail.Content.RawLink", [], "messages");
        echo " : <span>";
        echo twig_escape_filter($this->env, (isset($context["setPasswordUrl"]) || array_key_exists("setPasswordUrl", $context) ? $context["setPasswordUrl"] : (function () { throw new RuntimeError('Variable "setPasswordUrl" does not exist.', 15, $this->source); })()), "html", null, true);
        echo "</span>.</p>

  <p>";
        // line 17
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("InitPassword.Mail.Content.Regards", [], "messages");
        echo ",</p>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "email/init_password.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 17,  97 => 15,  92 => 13,  87 => 11,  79 => 8,  74 => 6,  68 => 4,  58 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'email/base.html.twig' %}

{% block body %}
  <p>{% trans with {'%name%': user.firstName ~ ' ' ~ user.lastName} %}InitPassword.Mail.Content.Hello{% endtrans %},</p>

  <p>{% trans %}InitPassword.Mail.Content.ClickLinkToChangePassword{% endtrans%}</p>
  <p>
    <a href=\"{{ setPasswordUrl }}\">{% trans %}InitPassword.Mail.Content.UpdateNow{% endtrans%}</a>.
  </p>

  <p>{% trans %}InitPassword.Mail.Content.AccountStillSecure{% endtrans%}</p>

  <p>{% trans %}InitPassword.Mail.Content.UpdatePasswordIfCompromised{% endtrans%}</p>

  <p>{% trans %}InitPassword.Mail.Content.RawLink{% endtrans%} : <span>{{ setPasswordUrl }}</span>.</p>

  <p>{% trans %}InitPassword.Mail.Content.Regards{% endtrans%},</p>
{% endblock %}
", "email/init_password.html.twig", "/srv/php/templates/email/init_password.html.twig");
    }
}
